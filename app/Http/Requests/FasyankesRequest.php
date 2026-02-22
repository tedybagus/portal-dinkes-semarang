<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Fasyankes;

class FasyankesRequest extends FormRequest
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
        $fasyankesId = $this->route('fasyankes') ? $this->route('fasyankes')->id : null;
        
        return [
            'kategori' => [
                'required',
                Rule::in(array_keys(Fasyankes::getKategoriOptions()))
            ],
            'nama' => [
                'required',
                'string',
                'max:255'
            ],
            'kode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('fasyankes', 'kode')->ignore($fasyankesId)
            ],
            'alamat' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
                'regex:/^-?\d{1,2}\.\d{1,8}$/'
            ],
            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
                'regex:/^-?\d{1,3}\.\d{1,8}$/'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kategori.required' => 'Kategori fasyankes harus dipilih',
            'kategori.in' => 'Kategori fasyankes tidak valid',
            
            'nama.required' => 'Nama fasyankes harus diisi',
            'nama.string' => 'Nama fasyankes harus berupa teks',
            'nama.max' => 'Nama fasyankes maksimal 255 karakter',
            
            'kode.required' => 'Kode fasyankes harus diisi',
            'kode.string' => 'Kode fasyankes harus berupa teks',
            'kode.max' => 'Kode fasyankes maksimal 50 karakter',
            'kode.unique' => 'Kode fasyankes sudah digunakan',
            
            'alamat.string' => 'Alamat harus berupa teks',
            'alamat.max' => 'Alamat maksimal 1000 karakter',
            
            'latitude.numeric' => 'Latitude harus berupa angka',
            'latitude.between' => 'Latitude harus antara -90 dan 90',
            'latitude.regex' => 'Format latitude tidak valid',
            
            'longitude.numeric' => 'Longitude harus berupa angka',
            'longitude.between' => 'Longitude harus antara -180 dan 180',
            'longitude.regex' => 'Format longitude tidak valid',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'kategori' => 'kategori',
            'nama' => 'nama fasyankes',
            'kode' => 'kode fasyankes',
            'alamat' => 'alamat',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Bersihkan whitespace
        if ($this->has('nama')) {
            $this->merge([
                'nama' => trim($this->nama)
            ]);
        }

        if ($this->has('kode')) {
            $this->merge([
                'kode' => strtoupper(trim($this->kode))
            ]);
        }

        // Convert empty strings to null untuk koordinat
        if ($this->latitude === '') {
            $this->merge(['latitude' => null]);
        }

        if ($this->longitude === '') {
            $this->merge(['longitude' => null]);
        }
    }
}
