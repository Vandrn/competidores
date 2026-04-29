<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePromoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $pais = $this->input('pais');
        $cat = $this->cadenasPorPais();
        $permitidas = $cat[$pais] ?? [];

        return [
            'pais'         => ['required','string','size:2'],
            'modalidad'    => ['required','string','max:50'],
            'cadena'       => ['required','string','max:160', Rule::in($permitidas)],
            'tipo'         => ['required','string','max:50'],
            'descripcion'  => ['required','string'],
            'no_fecha'     => ['nullable','boolean'],
            'fecha_inicio' => ['nullable','date','required_unless:no_fecha,1'],
            'fecha_fin'    => ['nullable','date','required_unless:no_fecha,1','after_or_equal:fecha_inicio'],
            'observaciones'=> ['nullable','string','max:255'],
            'images.*'     => ['nullable','image','mimes:jpg,jpeg,png','max:4096'],
        ];
    }

    protected function cadenasPorPais(): array
    {
        return [
            'CR' => ["Columbia","Adidas","Adoc","Aldo Nero","Arena","Arenas","Arenas Skate & Surf","Berskha","Best Brands","Cachos","CAT - Caterpillar","Charly Loft","DelBarco","Ecco","Extremos","Flexi","Fusion","Hot Shoes","Hush Puppies","Mix Shoes and Bags","Naturalizer","Nike","Nine West","Nuevo Mundo","Payless","Puma","Reebok","Simán","Skechers","Sportline","The North Face","Timberland","UnoSport","Usaflex","Zapatto (CNC)","Zara","ZumZum"],
            'SV' => ["Adidas","Adoc","Aldo Nero","Berskha","CAT - Caterpillar","Columbia","Flexi","GAP","Hush Puppies","Idol Fashion Store","Jam Calza","Kamar Store","Kenneth Cole","Lee Shoes","MD","Naturalizer","Nike","Nine West","Only Shoes","Par2","Park Avenue","Payless","Prisma Moda","Puma","Sears","Simán","Skechers","Sportline","Stradivarius","The North Face","Tienda Libre","Timberland","Usaflex","Via Brasil","Zara"],
            'GT' => ["Adidas","Adoc","Aldo Nero","Bass","Berskha","CAT - Caterpillar","Clarks","Cobán","Columbia","Converse","Flexi","GAP","Hush Puppies","Kenneth Cole","Lee Shoes","MD","Naturalizer","Nike","Nine West","Par2","Payless","Prisma Moda","Puma","Reebok","Rikely","Roy","Saúl E  Méndez","Simán","Skechers","SportCity","Sportline","Stradivarius","The North Face","Timberland","Torre Blanca","Zara"],
            'HN' => ["Adidas","Adoc","Aldo Nero","Carrion","CAT - Caterpillar","Charly","Columbia","Diunsa","Flexi","Hush Puppies","Kenneth Cole","Magic Shoes","MD","Naturalizer","Nike","Nine West","Par2","Payless","Puma","Reebok","Roy","Sermay","Skechers","Sportline","The North Face","Timberland","Time Out"],
            'NI' => ["Adidas","Adoc","CAT - Caterpillar","Columbia","El Gran Mall","Flexi","Go Marcas","Hush Puppies","Kicks","MD","Naturalizer","Nike","Nine West","Palm (Nuevo)","Par2","Payless","Puma","Shoes & More (Nuevo)","Simán","Sportline","Timberland"],
            'PA' => ['ADIDAS','ALDO NERO','AQUA FASHION','BBB SHOES & BOOTS','BELLAGIO','BELLINI','CALZASHOES',
            'CLARKS','COLUMBIA','CONWAY','DOMANI','ECCO','EL TITAN','ENERGY','ESTAMPA','FELIX','FLEXI',
            'FLORSHEIM','GUESS','JOHNSTON & MURPHY','KENNETH COLE','MADISON','MERCADO DE CALZADO',
            'MR. JONES','NINE WEST','OUTDOOR ADVENTURE','PAYLESS','SKECHERS','SPORTLINE','STEVENS',
            'STUDIO F','VÉLEZ',],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha inicio.',
            'cadena.in' => 'La cadena seleccionada no es válida para el país elegido.',
        ];
    }
}
