<?php

namespace App\Http\Requests;

use App\Const\LibraryCardType;
use App\Const\RouteName;
use App\Models\Client;
use App\Models\LibraryCard;
use App\Models\Rental;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RentalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->route()->action['as'] === RouteName::RENTAL_CREATE) {
            $this->additionalCreateRules();

            return [];
        }
        if($this->route()->action['as'] === RouteName::RENTAL_TOGGLE_ACTIVE) {
            return $this->toggleActiveRules();
        }
        if($this->route()->action['as'] === RouteName::RENTAL_EXTEND) {
            $this->additionalExtendRules();

            return [];
        }

        throw new HttpException(422, 'Unprocessable entity');
    }

    private function additionalCreateRules(): void
    {
        /** @var Client $client */
        $client = $this->route('client');
        /** @var LibraryCard $libraryCard */
        $libraryCard = $client->libraryCard()->first();

        if($client->activeRentalsCount() >= LibraryCardType::allowedNumberOfRentals($libraryCard->type)) {
            throw new HttpException(422, 'Max number of rentals reacted');
        }
        if($client->pendingFinesCount() > 0) {
            throw new HttpException(422, 'Client has unpaid fines');
        }
    }

    private function toggleActiveRules(): array
    {
        return [
            'active' => 'required|in:true,false'
        ];
    }

    private function additionalExtendRules(): void
    {
        /** @var Rental $rental */
        $rental = $this->route('rental');
        /** @var LibraryCard $libraryCard */
        $libraryCard = $rental->clientLibraryCard()->first();

        if($rental->extended_times >= LibraryCardType::allowedNumberOfRentals($libraryCard->type)) {
            throw new HttpException(422, 'Max number of extensions reached');
        }
    }
}
