<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [

            ['code' => 'AFN', 'name' => 'Afghan Afghani', 'symbol' => 'AFG'],
            ['code' => 'ALL', 'name' => 'Albanian Lek', 'symbol' => 'L'],
            ['code' => 'DZD', 'name' => 'Algerian Dinar', 'symbol' => 'د.ج'],
            ['code' => 'AOA', 'name' => 'Angolan Kwanza', 'symbol' => 'Kz'],
            ['code' => 'ARS', 'name' => 'Argentine Peso', 'symbol' => '$'],
            ['code' => 'AMD', 'name' => 'Armenian Dram', 'symbol' => '֏'],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => '$'],
            ['code' => 'AZN', 'name' => 'Azerbaijani Manat', 'symbol' => '₼'],
            ['code' => 'BHD', 'name' => 'Bahraini Dinar', 'symbol' => 'ب.د'],
            ['code' => 'BDT', 'name' => 'Bangladeshi Taka', 'symbol' => '৳'],
            ['code' => 'BYN', 'name' => 'Belarusian Ruble', 'symbol' => 'Br'],
            ['code' => 'BZD', 'name' => 'Belize Dollar', 'symbol' => '$'],
            ['code' => 'BOB', 'name' => 'Bolivian Boliviano', 'symbol' => 'Bs.'],
            ['code' => 'BAM', 'name' => 'Bosnia Convertible Mark', 'symbol' => 'KM'],
            ['code' => 'BRL', 'name' => 'Brazilian Real', 'symbol' => 'R$'],
            ['code' => 'BGN', 'name' => 'Bulgarian Lev', 'symbol' => 'лв'],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => '$'],
            ['code' => 'CLP', 'name' => 'Chilean Peso', 'symbol' => '$'],
            ['code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥'],
            ['code' => 'COP', 'name' => 'Colombian Peso', 'symbol' => '$'],
            ['code' => 'CRC', 'name' => 'Costa Rican Colón', 'symbol' => '₡'],
            ['code' => 'HRK', 'name' => 'Croatian Kuna', 'symbol' => 'kn'],
            ['code' => 'CZK', 'name' => 'Czech Koruna', 'symbol' => 'Kč'],
            ['code' => 'DKK', 'name' => 'Danish Krone', 'symbol' => 'kr'],
            ['code' => 'EGP', 'name' => 'Egyptian Pound', 'symbol' => '£'],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
            ['code' => 'GHS', 'name' => 'Ghanaian Cedi', 'symbol' => '₵'],
            ['code' => 'HKD', 'name' => 'Hong Kong Dollar', 'symbol' => '$'],
            ['code' => 'HUF', 'name' => 'Hungarian Forint', 'symbol' => 'Ft'],
            ['code' => 'ISK', 'name' => 'Icelandic Króna', 'symbol' => 'kr'],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹'],
            ['code' => 'IDR', 'name' => 'Indonesian Rupiah', 'symbol' => 'Rp'],
            ['code' => 'IRR', 'name' => 'Iranian Rial', 'symbol' => '﷼'],
            ['code' => 'IQD', 'name' => 'Iraqi Dinar', 'symbol' => 'ع.د'],
            ['code' => 'ILS', 'name' => 'Israeli Shekel', 'symbol' => '₪'],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥'],
            ['code' => 'JOD', 'name' => 'Jordanian Dinar', 'symbol' => 'د.ا'],
            ['code' => 'KZT', 'name' => 'Kazakhstani Tenge', 'symbol' => '₸'],
            ['code' => 'KES', 'name' => 'Kenyan Shilling', 'symbol' => 'KSh'],
            ['code' => 'KWD', 'name' => 'Kuwaiti Dinar', 'symbol' => 'د.ك'],
            ['code' => 'LKR', 'name' => 'Sri Lankan Rupee', 'symbol' => 'Rs'],
            ['code' => 'MYR', 'name' => 'Malaysian Ringgit', 'symbol' => 'RM'],
            ['code' => 'MXN', 'name' => 'Mexican Peso', 'symbol' => '$'],
            ['code' => 'MAD', 'name' => 'Moroccan Dirham', 'symbol' => 'د.م.'],
            ['code' => 'NPR', 'name' => 'Nepalese Rupee', 'symbol' => 'Rs'],
            ['code' => 'NZD', 'name' => 'New Zealand Dollar', 'symbol' => '$'],
            ['code' => 'NGN', 'name' => 'Nigerian Naira', 'symbol' => '₦'],
            ['code' => 'NOK', 'name' => 'Norwegian Krone', 'symbol' => 'kr'],
            ['code' => 'OMR', 'name' => 'Omani Rial', 'symbol' => 'ر.ع.'],
            ['code' => 'PKR', 'name' => 'Pakistani Rupee', 'symbol' => '₨'],
            ['code' => 'PEN', 'name' => 'Peruvian Sol', 'symbol' => 'S/'],
            ['code' => 'PHP', 'name' => 'Philippine Peso', 'symbol' => '₱'],
            ['code' => 'PLN', 'name' => 'Polish Zloty', 'symbol' => 'zł'],
            ['code' => 'QAR', 'name' => 'Qatari Riyal', 'symbol' => 'ر.ق'],
            ['code' => 'RON', 'name' => 'Romanian Leu', 'symbol' => 'lei'],
            ['code' => 'RUB', 'name' => 'Russian Ruble', 'symbol' => '₽'],
            ['code' => 'SAR', 'name' => 'Saudi Riyal', 'symbol' => '﷼'],
            ['code' => 'SGD', 'name' => 'Singapore Dollar', 'symbol' => '$'],
            ['code' => 'ZAR', 'name' => 'South African Rand', 'symbol' => 'R'],
            ['code' => 'KRW', 'name' => 'South Korean Won', 'symbol' => '₩'],
            ['code' => 'SEK', 'name' => 'Swedish Krona', 'symbol' => 'kr'],
            ['code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF'],
            ['code' => 'THB', 'name' => 'Thai Baht', 'symbol' => '฿'],
            ['code' => 'TRY', 'name' => 'Turkish Lira', 'symbol' => '₺'],
            ['code' => 'UAH', 'name' => 'Ukrainian Hryvnia', 'symbol' => '₴'],
            ['code' => 'AED', 'name' => 'UAE Dirham', 'symbol' => 'د.إ'],
            ['code' => 'GBP', 'name' => 'British Pound Sterling', 'symbol' => '£'],
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$'],
            ['code' => 'VND', 'name' => 'Vietnamese Dong', 'symbol' => '₫'],

        ];



        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}
