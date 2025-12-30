<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegalAidProvider>
 */
class LegalAidProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanzaniaLocations = [
            'Arusha' => ['Arusha City', 'Arusha District', 'Karatu', 'Longido', 'Meru', 'Monduli', 'Ngorongoro'],
            'Dar es Salaam' => ['Ilala', 'Kinondoni', 'Temeke', 'Kigamboni', 'Ubungo'],
            'Dodoma' => ['Dodoma City', 'Bahi', 'Chamwino', 'Chemba', 'Kondoa', 'Kongwa', 'Mpwapwa'],
            'Geita' => ['Geita', 'Bukombe', 'Chato', 'Mbogwe', 'Nyang\'hwale'],
            'Iringa' => ['Iringa', 'Kilolo', 'Mufindi'],
            'Kagera' => ['Bukoba', 'Biharamulo', 'Karagwe', 'Kyerwa', 'Missenyi', 'Muleba', 'Ngara'],
            'Katavi' => ['Mpanda', 'Mlele', 'Tanganyika'],
            'Kigoma' => ['Kigoma', 'Buhigwe', 'Kakonko', 'Kasulu', 'Kibondo', 'Uvinza'],
            'Kilimanjaro' => ['Moshi', 'Hai', 'Mwanga', 'Rombo', 'Same', 'Siha'],
            'Lindi' => ['Lindi', 'Kilwa', 'Liwale', 'Nachingwea', 'Ruangwa'],
            'Manyara' => ['Babati', 'Hanang', 'Kiteto', 'Mbulu', 'Simanjiro'],
            'Mara' => ['Musoma', 'Bunda', 'Butiama', 'Rorya', 'Serengeti', 'Tarime'],
            'Mbeya' => ['Mbeya', 'Chunya', 'Kyela', 'Mbarali', 'Rungwe'],
            'Morogoro' => ['Morogoro', 'Gairo', 'Kilombero', 'Kilosa', 'Malinyi', 'Mvomero', 'Ulanga'],
            'Mtwara' => ['Mtwara', 'Masasi', 'Nanyumbu', 'Newala', 'Tandahimba'],
            'Mwanza' => ['Ilemela', 'Nyamagana', 'Kwimba', 'Magu', 'Misungwi', 'Sengerema', 'Ukerewe'],
            'Njombe' => ['Njombe', 'Ludewa', 'Makete', 'Wanging\'ombe'],
            'Pwani' => ['Kibaha', 'Bagamoyo', 'Kisarawe', 'Mafia', 'Mkuranga', 'Rufiji'],
            'Rukwa' => ['Sumbawanga', 'Kalambo', 'Nkasi'],
            'Ruvuma' => ['Songea', 'Mbinga', 'Namtumbo', 'Nyasa', 'Tunduru'],
            'Shinyanga' => ['Shinyanga', 'Kahama', 'Kishapu'],
            'Simiyu' => ['Bariadi', 'Busega', 'Itilima', 'Maswa', 'Meatu'],
            'Singida' => ['Singida', 'Ikungi', 'Iramba', 'Manyoni', 'Mkalama'],
            'Songwe' => ['Vwawa', 'Ileje', 'Mbozi', 'Momba'],
            'Tabora' => ['Tabora', 'Igunga', 'Kaliua', 'Nzega', 'Sikonge', 'Urambo', 'Uyui'],
            'Tanga' => ['Tanga City', 'Handeni', 'Kilindi', 'Korogwe', 'Lushoto', 'Muheza', 'Mkinga', 'Pangani'],
        ];

        $region = $this->faker->randomElement(array_keys($tanzaniaLocations));
        $district = $this->faker->randomElement($tanzaniaLocations[$region]);

        return [
            'reg_no' => 'LAP-' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->company,
            'licence_no' => 'LIC-' . $this->faker->unique()->numberBetween(10000, 99999),
            'approved_date' => $this->faker->dateTimeBetween('2019-01-01', 'now')->format('Y-m-d'),
            'licence_expiry_date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'region' => $region,
            'district' => $district,
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'paid' => $this->faker->boolean(40), // 40% chance of being paid
        ];
    }
}
