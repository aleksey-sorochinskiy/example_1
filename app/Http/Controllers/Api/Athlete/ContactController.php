<?php

namespace App\Http\Controllers\Api\Athlete;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Athlete\UpdateContact;

/**
 * Class ContactController
 * Controller
 *
 * @package App\Http\Controllers\Api\Athlete
 */
class ContactController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @api
     * @link /contact/{contact} PUT/PATCH
     *
     * @param  UpdateContact  $request
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContact $request, Contact $contact)
    {
        $contact->update($request->all());

        return response($contact->fresh());
    }
}
