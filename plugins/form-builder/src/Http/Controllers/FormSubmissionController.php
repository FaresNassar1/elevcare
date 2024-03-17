<?php

namespace Progmix\FormBuilder\Http\Controllers;

use Progmix\FormBuilder\Http\Datatables\FormSubmissionsDatatable;
use Progmix\FormBuilder\Models\FormSubmission;
use Progmix\FormBuilder\Models\Translation;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use Illuminate\View\View;
use Juzaweb\Backend\Models\Language;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Traits\ResourceController;
use Progmix\FormBuilder\Http\Requests\FormSubmissionsRequest;

class FormSubmissionController extends BackendController
{

    use ResourceController {
        getDataForForm as DataForForm;
        afterSave as tAfterSave;
    }
    protected $viewPrefix = 'formBuilder::backend';

    public function index(...$params): View
    {

        $langsArray = Language::where('default', 1)->get();
        $langs = $langsArray->pluck('name', 'code')->toArray();

        $this->checkPermission(
            'index',
            $this->getModel(...$params),
            ...$params
        );

        if (method_exists($this, 'getBreadcrumbPrefix')) {
            $this->getBreadcrumbPrefix(...$params);
        }

        return view(
            "{$this->viewPrefix}.submissions",
            array_merge(
                [
                    'langs' => $langs,
                ],
                $this->getDataForIndex(...$params)
            )
        );
    }

    protected function getDataTable(...$params)
    {
        return new FormSubmissionsDatatable();
    }

    protected function validator(array $attributes, ...$params)
    {
        return true;
    }

    protected function getModel(...$params)
    {
        return FormSubmission::class;
    }

    protected function getTitle(...$params)
    {
        return 'Forms Submissions';
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model);
        return $data;
    }

    public function saveFormJson(FormSubmissionsRequest $request)
    {
        //  dd($request->submission);
        //need validation here in cms
        FormSubmission::create([
            'form_id' => $request->dynamicCode['id'],
            'form_data' => json_encode($request->submission),
            'meta_data' => json_encode($request->metadata),
        ]);

        return Response::json(['message' => 'Success'], 200);
    }

    public function view($id)
    {
        $formSubmission = FormSubmission::findOrFail($id);
        $formData = json_decode($formSubmission['form_data'], true);
        $data = $formData['data'];
        $lang = app()->getLocale();

        $title = $formSubmission->form->name;
        return view('formBuilder::view', compact('formSubmission', 'lang', 'data', 'title'));
    }

    // public function edit($id)
    // {
    //     $formSubmission = FormSubmission::findOrFail($id);
    //     $formData = json_decode($formSubmission['form_data'], true);
    //     $data = $formData['data'];
    //     $path = '/en/test';
    //     $pathSegments = explode('/', trim($path, '/'));
    //     $lang = $pathSegments[0];
    //     $title = 'view Form';
    //     return view('formBuilder::view', compact('formSubmission', 'lang', 'title','data'));
    // } the error was here
}
