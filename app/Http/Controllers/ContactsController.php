<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Support\Facades\Redirect;
use Mockery\Exception;

class ContactsController extends Controller
{
    public function getContacts(Request $request)
    {
        $contact_table = "";
        $phone_table = "";
        $add_edit = 'add';
        $error = "";
        $ides = null;

        try {

            if ($request->isMethod('POST')) {

                if ($request->has('addedit')) {

                    if ((!$request->has('contact_table') || !$request->has('phone_table')) & $request->add_edit == 'add') {
                        throw new Exception('Укажите контакт и телефон для добавления в телефонную книгу');
                    }

                    if ($request->add_edit == 'add') {
                        $contact = Contact::where('contact', '=', $request->contact_table)->get();
                        $add_edit = 'add';
                    }
                    else {
                        $contact = Contact::where([['contact', '=', $request->contact_table], ['id', '<>', $request->id]])->get();
                        $add_edit = 'edit';
                    }

                    if (!$contact->isEmpty()) {
                        $contact_table = $request->contact_table;
                        $phone_table = $request->phone_table;
                        throw new Exception('Такой контакт уже существует');
                    }

                    if ($request->add_edit == 'add') {
                        Contact::create([
                            'contact' => $request->contact_table,
                            'phone' => $request->phone_table
                        ]);
                    }
                    elseif ($request->has('id')) {
                        (new Contact())->updateContact($request);
                    }
                }
                else if ($request->has('find')) {
                    $contact_table = $request->contact_table;
                    $phone_table = $request->phone_table;
                    $ides = (new Contact())->getFind($request);

                    if (empty($ides)) {
                        throw new Exception('По вашему запросу ничего не найдено');
                    }
                }

                else if ($request->has('reset')) {
                    $add_edit = 'add';
                    return redirect()->route('contact');
                }

            }

            if ($request->has('action')  && !$request->isMethod('POST')) {

                if ($request->action=='edit') {
                    $add_edit = 'edit';
                }

                if ($request->action == 'edit'  & $add_edit == 'edit') {
                    $contact = (new Contact())->getContact($request->id);
                    $contact_table = $contact->contact;
                    $phone_table = $contact->phone;
                }
                elseif (($request->action == 'delete')) {
                    (new Contact())->delContact($request->id);
                }

            }

        }
        catch (Exception $e) {
            $error = $e->getMessage();
        }
        finally {
            $contacts = Contact::get();

            return view('contacts', [
                'contacts' => $contacts,
                'add_edit' => $add_edit,
                'contact_table' => $contact_table,
                'phone_table' => $phone_table,
                'error' => $error,
                'ides' => $ides
            ]);
        }
    }
}
