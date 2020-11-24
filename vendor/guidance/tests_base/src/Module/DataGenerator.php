<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module;

class DataGenerator
{
    private const VISA_CREDIT_CARD_NUMBERS             = ['4111111111111111'];
    private const MASTER_CARD_CREDIT_CARD_NUMBERS      = ['5555555555554444', '5105105105105100'];
    private const AMERICAN_EXPRESS_CREDIT_CARD_NUMBERS = ['378282246310005', '371449635398431'];

    private const AMERICAN_LOCAL_PHONE_NUMBER_ADD = '202-';
    private const AUSTRALIAN_LOCAL_PHONE_NUMBER_ADD = '0491-';
    private const CANADIAN_LOCAL_PHONE_NUMBER_ADD = '613-';
    private const NEW_ZELAND_LOCAL_PHONE_NUMBER_ADD = '3-3';

    private const AMERICAN_INTERNATIONAL_PHONE_NUMBER_ADD = '1-202-';
    private const AUSTRALIAN_INTERNATIONAL_PHONE_NUMBER_ADD = '61-491-';
    private const CANADIAN_INTERNATIONAL_PHONE_NUMBER_ADD = '1-613-';
    private const NEW_ZELAND_INTERNATIONAL_PHONE_NUMBER_ADD = '64-3-3';

    /** @var \Faker\Generator */
    private $faker = null;

    // ########################################

    public function __construct(\Faker\Generator $faker)
    {
        $this->faker = $faker;
    }

    // ########################################

    public function getString(int $maxLength = 0): string
    {
        $hash = sha1(random_int(1, 1000000) . microtime(true));

        if ($maxLength > 0) {
            $hash = substr($hash, 0, $maxLength);
        }

        return $hash;
    }

    public function getNumber($nbDigits = null, bool $strict = true): int
    {
        return $this->faker->randomNumber($nbDigits, $strict);
    }

    public function getNumberBetween(int $min = 0, int $max = 2147483647): int
    {
        return $this->faker->numberBetween($min, $max);
    }

    public function getFloat($nbMaxDecimals = null, $min = 0, $max = null): float
    {
        return $this->faker->randomFloat($nbMaxDecimals, $min, $max);
    }

    public function getText(): string
    {
        return $this->faker->text;
    }

    public function getCompany(): string
    {
        return $this->faker->company;
    }

    public function getEmail(): string
    {
        return $this->faker->email;
    }

    public function getAddress(): string
    {
        return $this->faker->address;
    }

    public function getState(): string
    {
        return $this->faker->state;
    }

    public function getCity(): string
    {
        return $this->faker->city;
    }

    public function getCountry(): string
    {
        return $this->faker->country;
    }

    public function getCountryCode(): string
    {
        return $this->faker->countryCode;
    }

    public function getStreetName(): string
    {
        return $this->faker->streetName;
    }

    public function getStreetAddress(): string
    {
        return $this->faker->streetAddress;
    }

    public function getZip(): string
    {
        return $this->faker->postcode;
    }

    // ----------------------------------------

    public function getCreditCardType(): string
    {
        return $this->faker->creditCardType;
    }

    public function getCreditCardNumber(): string
    {
        return $this->faker->creditCardNumber;
    }

    public function getCreditCardExpirationDate(): \DateTime
    {
        return $this->faker->creditCardExpirationDate;
    }

    public function getCreditCardDetails(): array
    {
        return $this->faker->creditCardDetails;
    }

    // ----------------------------------------

    public function getTestVisa(): string
    {
        return self::VISA_CREDIT_CARD_NUMBERS[array_rand(self::VISA_CREDIT_CARD_NUMBERS)];
    }

    public function getTestSpecificVisa($preferable = true): string
    {
        return ($preferable)
            ? self::VISA_CREDIT_CARD_NUMBERS[0]
            : self::VISA_CREDIT_CARD_NUMBERS[1];
    }

    // ----------------------------------------

    public function getTestAmericanExpress(): string
    {
        return self::AMERICAN_EXPRESS_CREDIT_CARD_NUMBERS[array_rand(self::AMERICAN_EXPRESS_CREDIT_CARD_NUMBERS)];
    }

    public function getTestSpecificAmericanExpress($preferable = true): string
    {
        return ($preferable)
            ? self::AMERICAN_EXPRESS_CREDIT_CARD_NUMBERS[0]
            : self::AMERICAN_EXPRESS_CREDIT_CARD_NUMBERS[1];
    }

    // ----------------------------------------

    public function getTestMasterCard(): string
    {
        return self::MASTER_CARD_CREDIT_CARD_NUMBERS[array_rand(self::MASTER_CARD_CREDIT_CARD_NUMBERS)];
    }

    public function getTestSpecificMasterCard($preferable = true): string
    {
        return ($preferable)
            ? self::MASTER_CARD_CREDIT_CARD_NUMBERS[0]
            : self::MASTER_CARD_CREDIT_CARD_NUMBERS[1];
    }

    // ----------------------------------------

    public function getCreditCardExpirationDateString(): string
    {
        return $this->faker->creditCardExpirationDateString;
    }

    public function getFirstName(): string
    {
        return $this->faker->firstName;
    }

    public function getFirstNameMale(): string
    {
        return $this->faker->firstNameMale;
    }

    public function getFirstNameFemale(): string
    {
        return $this->faker->firstNameFemale;
    }

    public function getLastName(): string
    {
        return $this->faker->lastName;
    }

    public function getName(): string
    {
        return $this->faker->name;
    }

    public function getNickName(): string
    {
        return $this->faker->userName;
    }

    public function getDate($format, $max = 'now'): string
    {
        return $this->faker->date($format, $max);
    }

    public function getDateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null): \DateTime
    {
        return $this->faker->dateTimeBetween($startDate, $endDate, $timezone);
    }

    public function getPassword($minLength = 8, $maxLength = 20): string
    {
        return $this->faker->password($minLength, $maxLength);
    }
    
    public function getLocalPhoneNumber(): string
    {
        switch (\Guidance\Tests\Base\RuntimeContainer::getCountry()) {
            case 'United States': return self::AMERICAN_LOCAL_PHONE_NUMBER_ADD . $this->getNumber(3) . '-' . $this->getNumber(4);
            case 'Canada':        return self::CANADIAN_LOCAL_PHONE_NUMBER_ADD . $this->getNumber(3) . '-' . $this->getNumber(4);
            case 'Australia':     return self::AUSTRALIAN_LOCAL_PHONE_NUMBER_ADD . $this->getNumber(3) . '-' . $this->getNumber(3);
            case 'New Zealand':    return self::NEW_ZELAND_LOCAL_PHONE_NUMBER_ADD . $this->getNumber(6);
            default: return '';
        }
    }

    public function getInternationalPhoneNumber(): string
    {
        switch (\Guidance\Tests\Base\RuntimeContainer::getCountry()) {
            case 'United States': return self::AMERICAN_INTERNATIONAL_PHONE_NUMBER_ADD . $this->getNumber(3) . '-' . $this->getNumber(4);
            case 'Canada':        return self::CANADIAN_INTERNATIONAL_PHONE_NUMBER_ADD . $this->getNumber(3) . '-' . $this->getNumber(4);
            case 'Australia':     return self::AUSTRALIAN_INTERNATIONAL_PHONE_NUMBER_ADD . $this->getNumber(3) . '-' . $this->getNumber(3);
            case 'New Zealand':   return self::NEW_ZELAND_INTERNATIONAL_PHONE_NUMBER_ADD . $this->getNumber(2) . '-' . $this->getNumber(4);
            default: return '';
        }
    }

    // ########################################
}
