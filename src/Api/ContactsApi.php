<?php

namespace Bluerock\Sellsy\Api;

use Bluerock\Sellsy\Core\Response;
use Bluerock\Sellsy\Entities\Contact;
use Bluerock\Sellsy\Collections\ContactCollection;

/**
 * The API client for the `contacts` namespace.
 *
 * @package bluerock/sellsy-client
 * @author Thomas <thomas@bluerocktel.com>
 * @version 1.1
 * @access public
 * @see https://api.sellsy.com/doc/v2/#tag/Contacts
 */
class ContactsApi extends AbstractApi
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();

        $this->entity     = Contact::class;
        $this->collection = ContactCollection::class;
    }

    /**
     * List all contacts.
     *
     * @param array $query Query parameters.
     *
     * @return \Illuminate\Http\Client\Response
     * @see https://api.sellsy.com/doc/v2/#operation/get-contacts
     */
    public function index(array $query = []): Response
    {
        $response = $this->connection
                        ->request('contacts')
                        ->get($query);

        return $this->prepareResponse($response);
    }

    /**
     * Show a single contact by id.
     *
     * @param string $id     The contact id to retrieve.
     * @param array  $query  Query parameters.
     *
     * @return \Bluerock\Sellsy\Core\Response
     * @see https://api.sellsy.com/doc/v2/#operation/get-contact
     */
    public function show(string $id, array $query = []): Response
    {
        $response = $this->connection
                        ->request("contacts/{$id}")
                        ->get($query);

        return $this->prepareResponse($response);
    }

    /**
     * Store (create) an contact.
     *
     * @param Contact $contact The contact entity to store.
     * @param array   $query   Query parameters.
     *
     * @return \Bluerock\Sellsy\Core\Response
     * @see https://api.sellsy.com/doc/v2/#operation/create-contact
     */
    public function store(Contact $contact, array $query = []): Response
    {
        $body = $contact->except('id')
                        ->except('owner')
                        ->toArray();

        $response = $this->connection
                        ->request('contacts')
                        ->post(array_filter($body) + $query);
        
        return $this->prepareResponse($response);
    }

    /**
     * Update an existing contact.
     *
     * @param Contact $contact The contact entity to store.
     * @param array   $query   Query parameters.
     *
     * @return \Bluerock\Sellsy\Core\Response
     * @see https://api.sellsy.com/doc/v2/#operation/update-contact
     */
    public function update(Contact $contact, array $query = []): Response
    {
        $body = $contact->except('id')
                        ->except('owner')
                        ->toArray();

        $response = $this->connection
                        ->request("contacts/{$contact->id}")
                        ->put(array_filter($body) + $query);
        
        return $this->prepareResponse($response);
    }

    /**
     * Delete an existing contact.
     *
     * @param int $id The contact id to be deleted.
     *
     * @return \Bluerock\Sellsy\Core\Response
     * @see https://api.sellsy.com/doc/v2/#operation/delete-contact
     */
    public function destroy(int $id): Response
    {
        $response = $this->connection
                        ->request("contacts/{$id}")
                        ->delete();
        
        return $this->prepareResponse($response);
    }
}
