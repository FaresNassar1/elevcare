<?php

namespace Juzaweb\Contacts\Actions;

use Juzaweb\CMS\Abstracts\Action;

class ContactsAction extends Action
{
    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenu']);

    }
    public function addAdminMenu()
    {
        $this->hookAction->registerPermissionGroup(
            'contacts',
            [
                'name' => "contacts",
                'description' => "Contacts",
                'key' => "contacts",
            ]
        );
        $this->hookAction->registerPermission(
            "contacts_index",
            [
                'name' => "contacts.index",
                'group' => "contacts",
                'description' => "View List contacts",
                'key' => "contacts",

            ]
        );
        $this->hookAction->registerPermission(
            "contacts_edit",
            [
                'name' => "contact.edit",
                'group' => "contacts",
                'description' => "View contact",
                'key' => "contacts",

            ]
        );
    }
}
