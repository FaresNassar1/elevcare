<?php

namespace Progmix\FormBuilder\Http\Controllers;

use Progmix\FormBuilder\Http\Datatables\FormsDatatable;
use Progmix\FormBuilder\Models\Form;
use Progmix\FormBuilder\Models\FormSubmission;
use Progmix\FormBuilder\Models\Translation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Backend\Models\Language;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Traits\ResourceController;
use Spatie\TranslationLoader\LanguageLine;

class FormBuilderController extends BackendController
{

    use ResourceController {
        getDataForForm as DataForForm;
        afterSave as tAfterSave;
    }

    protected $viewPrefix = 'formBuilder::backend';

    protected function getDataTable(...$params)
    {
        return new FormsDatatable();
    }

    protected function validator(array $attributes, ...$params)
    {
        return true;
    }

    protected function getModel(...$params)
    {
        return Form::class;
    }

    protected function getTitle(...$params)
    {
        return  trans('cms::app.forms_builder');
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model);
        return $data;
    }

    public function create()
    {
        return view('formBuilder::add', [
            'title' => 'form builder',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $formData = $request->input('json_definition');
            $form = new Form();
            $form->form_definition = json_encode($formData);
            $form->name =  $request->input('form_name');
            $validations =  $this->getValidations($formData, $form->id); // iwant to send the id here of the record
            $form->validations =  json_encode($validations);
            $form->save();
            return response()->json(['id' => $form->id], 200);
        } catch (QueryException $e) {
            Log::error('QueryException : ' . $e);
            return response()->json(['error' => 'Database error'], 500);
        } catch (\Exception $e) {
            Log::error('Exception : ' . $e);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function edit($id)
    {

        $form = Form::findOrFail($id);
        $title = $form->name;
        return view('formBuilder::edit', compact('form',  'title'));
    }

    public function update(Form $form, Request $request)
    {
        try {
            $formData = $request->input('json_definition');
            $validations =  $this->getValidations($formData, $form->id);
            $form->form_definition = json_encode($formData);
            $form->name = $request->input('form_name');
            $form->validations =  json_encode($validations);
            $form->save();

            return response()->json(['id' => $form->id], 200);
        } catch (QueryException $e) {
            Log::error('QueryException : ' . $e);
            return response()->json(['error' => 'Database error'], 500);
        } catch (\Exception $e) {
            Log::error('Exception : ' . $e);

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function preview($id)
    {
        $form = Form::findOrFail($id);
        $data = json_decode($form->form_definition, true);
        $lang = [];
        $translationsResult = [];
        foreach ($data as $component) {

            if (isset($component['label']) && !empty($component['label'])) {

                $translations = LanguageLine::where('namespace', 'formBuilder')->where('group', 'plugin')->where('key', $component['label'])->get();

                if ($translations->count()) {

                    foreach ($translations as $translation) {

                        $translationsData = $translation->text;

                        if (!empty($translationsData)) {
                            foreach ($translationsData as $lang => $translationText) {
                                if (!isset($translations[$lang])) {
                                    $translationsResult[$lang] = [];
                                }
                                $translationsResult[$lang][$translation->key] = $translationText;
                            }
                        }
                    }
                }
            }
        }

        $langJson = json_encode($translationsResult);
        $title = 'preview';
        return view('formBuilder::show', compact('form', 'langJson', 'title'));
    }

    public function getFormJson(Form $form)
    {
        $data = json_decode($form->form_definition, true);
        $lang = [];
        $translationsResult = [];

        foreach ($data as $component) {
            if (isset($component['label']) && !empty($component['label'])) {
                $labelKey = $component['label'];
                if ($labelKey) {
                    $translations = LanguageLine::where('namespace', 'formBuilder')->where('group', 'plugin')->where('key', $labelKey)->get();
                    if ($translations->count()) {
                        foreach ($translations as $translation) {
                            $translationsData = $translation->text;
                            if (!empty($translationsData)) {
                                foreach ($translationsData as $lang => $translationText) {
                                    if (!isset($translationsResult[$lang])) {
                                        $translationsResult[$lang] = [];
                                    }
                                    $translationsResult[$lang][$translation->key] = $translationText;
                                }
                            }
                        }
                    }
                }
            }
        }

        $langJson = json_encode($translationsResult);
        return [
            'form_definition' => $form->form_definition,
            'langJson' => $langJson,
        ];
    }

    public function submitForm(Request $request, $id)
    {
        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    private function getValidations($formData, $id)
    {
        $validations = [];
        foreach ($formData as $component) {
            if (isset($component['validate'])) {
                foreach ($component['validate'] as $attributes => $value) {
                    if ($value) {
                        if (in_array($attributes, ['minLength'])) {
                            $validations[$component['key']][] = 'min:' . $value;
                        }
                        if (in_array($attributes, ['maxLength'])) {
                            $validations[$component['key']][] = 'max:' . $value;
                        }
                        if ($attributes == 'required' &&  $value == true) {
                            $validations[$component['key']][] = 'required';
                        }
                        //'onlyAvailableItems','minSelectedCount', 'maxSelectedCount'
                        if (in_array($attributes, ['minWords', 'maxWords',   'min', 'max'])) {
                            $validations[$component['key']][] = $attributes . ':' . $value;
                        }

                        if ($attributes == 'onlyAvailableItems' && $value == true) {
                            $validations[$component['key']][] = 'onlyAvailableItems:' . $id . ',' . $component['key'];
                        }

                        if ($attributes == 'pattern') {
                            $validations[$component['key']][] = 'regex:' . $value;
                        }
                    }
                }
            }

            if (isset($component['unique'])) {
                $validations[$component['key']][] = 'uniqueJson:' . $id . ',' . $component['key'];
            }

            if ($component['type'] == 'datetime') {
                if (isset($component['datePicker'])) {
                    $validations[$component['key']][] = 'before:' . $component['maxDate'];
                    $validations[$component['key']][] = 'after:' . $component['minDate'];
                }
            }
            if ($component['type'] == 'day') {
                $validations[$component['key']][] = 'before:' . $component['maxDate'];
                $validations[$component['key']][] = 'after:' . $component['minDate'];
            }
        }
        return $validations;
    }
}
