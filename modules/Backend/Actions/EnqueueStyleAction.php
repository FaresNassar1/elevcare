<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

class EnqueueStyleAction extends Action
{
    public function handle()
    {
        $this->addAction(self::BACKEND_HEADER_ACTION, [$this, 'enqueueStylesHeader']);
        $this->addAction(self::BACKEND_FOOTER_ACTION, [$this, 'enqueueStylesFooter']);
    }

    public function enqueueStylesHeader()
    {
        $scripts = HookAction::getEnqueueScripts();
        $styles = HookAction::getEnqueueStyles();
        // dd($scripts, $styles);
        echo view(
            'cms::admin.styles',
            ['scripts' => $scripts, 'styles' => $styles]
        )->render();
    }

    public function enqueueStylesFooter()
    {
        $scripts = HookAction::getEnqueueScripts(true);
        $styles = HookAction::getEnqueueStyles(true);

        echo view(
            'cms::admin.styles',
            ['scripts' => $scripts, 'styles' => $styles]
        )->render();
    }
}
