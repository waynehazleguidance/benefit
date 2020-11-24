<?php

declare(strict_types=1);

namespace Guidance\Tests\Project\Test\Project;

class BenefitAccept extends \Guidance\Tests\Project\Test\BaseAbstract
{
    // ########################################

    protected function processStateAndPreconditions(): void
    {


        // ========================================Data registry

        $city1 = $this->dataGenerator->getCity();
        $city2 = $this->dataGenerator->getCity();

        $email         = $this->dataGenerator->getEmail();
        $country       = $this->dataGenerator->getCountry();
        $streetAddress = $this->dataGenerator->getStreetAddress();

        // ========================================Data provider

        $testIndividualData = $this->dataSetProviderIndividual->getData('/city_chic/PDP/id/');
        $testIndividualFile = $this->dataSetProviderIndividual->getFile('guid.png');

        $testGeneralData = $this->dataSetProviderGeneral->getData('/browser/chrome/extension/store/');
        $testGeneralFile = $this->dataSetProviderGeneral->getFile('/browser/chrome/extension/watermark.png');
    }

    // ########################################


    public function Murad(\Guidance\Tests\Project\Actor $I)
    {
        // *****************************************************
        // Go to HOME PAGE
        // *****************************************************
        $I->amOnUrl('https://www.murad.com/');
        $I->maximizeWindow();
        $I->waitForText('Unbox', 30); // secs
        $I->see('Unbox');
        // *****************************************************
        // Get rid of coupon
        // *****************************************************
        $I->click(['css' => '.sign-in-btn']);
        $I->waitForText('Email', 30); // secs

        // ****************************
        // Sign In
        //  *******************************
        // ... $I->click(['css' => 'button.btn:nth-child(4)']);

        $I->waitForText('Sign', 30); // secs
        $I->fillField(['id' => 'login_email'], 'wayne.hazle@guidance.com');
        //$I->wait(3);
        $I->fillField(['id' => 'login_pass'], '@Testing123');
        //$I->wait(2);
        $I->click(['css' => '#sign-in-submit']);
        $I->waitForText('Wayne', 30); // secs

        //  CLICK MENUS instead of going directly to URLS
        $I->amOnPage('/');  // Go o Home Page
        // *****************************************************************************
        //  GO TO SHOP
        // ***********************************************************

        // $I->click(['css' => 'div.navigation:nth-child(1) > div:nth-child(1) > a:nth-child(1)']);
        // $I->waitForText('bestsellers', 30); // secs
        // $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO OUR STORY
        // ***********************************************************
        $I->click(['css' => 'div.navigation:nth-child(2) > div:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('History', 30); // secs
        $I->see('History');

        // *****************************************************************************
        //  GO TO ABOUT YOUR SKIN
        // ***********************************************************
        $I->click(['css' => 'div.header-item:nth-child(3) > div:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('skincare', 30); // secs
        $I->see('skincare');

        // *****************************************************************************
        //  SEARCH from HOMEPAGE -
        // ***********************************************************
        $I->amOnPage('/');
        $I->click(['css' => '.search > div:nth-child(1) > img:nth-child(1)']);
        $I->wait(3);
        $I->fillField(['id' => 'search'], 'Eye');
        $I->wait(2);
        $I->pressKey(['id' => 'search'],\Facebook\WebDriver\WebDriverKeys::ENTER);
        $I->waitForText('Eye', 30); // secs
        $I->see('eye');

        // *****************************************************************************
        //  Go to a PDP and Add to Cart
        // ***********************************************************
        $I->amOnUrl('https://www.murad.com/product/vita-c-eyes-dark-circle-corrector/');
        $I->waitForText('Circle', 30); // secs
        $I->see('Circle');

        // Click Add to Cart
       / $I->see('bag');
        $I->click(['css' => 'input.form-action-addToCart:nth-child(5)']);
        $I->waitForText('check', 30); // secs
        $I->see('check');
        $I->click(['css' => '.button--action']);

        // $I->moveMouseOver(['css' => '#navBtn-mini-cart']);
        $I->waitForText('Cart', 30); // secs

    }
    // ########################################



    public function _BenefitUSA(\Guidance\Tests\Project\Actor $I)
    {

        $I->amOnUrl('https://www.benefitcosmetics.com/en-us/');
        $I->maximizeWindow();
        $I->waitForText('brows', 30); // secs
        $I->see('brows');
        // Click Accept Cookies Popup
        $I->waitForText('Cookies', 30); // secs
        $I->see('Cookies');
        $I->click(['css' => '#onetrust-accept-btn-handler']);
        $I->wait(4);

        // ****************************
        // Sign In
        //  *******************************
        $I->moveMouseOver(['css' => '.icon-arrow-down:nth-child(2)']);
        $I->waitForText('Sign', 30); // secs
        $I->fillField(['id' => 'login_form_email'], 'wayne.hazle@guidance.com');
        //$I->wait(3);
        $I->fillField(['id' => 'login_form_password'], '@Testing123');
        //$I->wait(2);
        $I->click(['css' => 'button.btn:nth-child(4)']);
        $I->wait(4);

        // *****************************************************************************
        //  GO TO MY ACCOUNT -
        // ***********************************************************
        $I->amOnPage('/account');
        $I->waitForText('profile', 30); // secs
        $I->see('profile');

        // *****************************************************************************
        //  SEARCH from HOMEPAGE -
        // ***********************************************************
        $I->amOnPage('/');

        $I->fillField(['css' => '#search-input'], 'Eye');
        $I->wait(2);
        $I->pressKey(['css' => '#search-input'],\Facebook\WebDriver\WebDriverKeys::ENTER);
        $I->waitForText('Eye', 30); // secs
        $I->see('eye');

        // *****************************************************************************
        //  GO TO PLP - Editor's Pick & Apply a filter
        // ***********************************************************
        // 2. Go to Simple SHOP ALL PLP page----------------------------------------------------------------------------
        $I->amOnPage('/brow-makeup');
        $I->waitForText('brows', 30); // secs
        $I->see('brows');

        $I->click(['css' => '#ac-0 > button:nth-child(1)']);
        $I->wait(1);
        $I->click(['css' => '#filter-20']);
        $I->wait(5);

        // *****************************************************************************
        //  Go to a PDP and Add to Cart
        // ***********************************************************
        $I->amOnPage('/product/24-hour-brow-setter-clear-brow-gel?product=24HOUBM66-FULL&sku=BM66');
        $I->waitForText('brow', 30); // secs
        $I->see('Brow');

        // Change count
        $I->click(['css' => 'form.product-info__section > div:nth-child(1) > div:nth-child(1) > button:nth-child(3)']);

        // Click Add to Cart
        $I->see('Add to Cart');
        $I->click(['css' => 'form.product-info__section > button:nth-child(2)']);
        //$I->waitForText('Added to cart!');
        $I->wait(4);

        // *****************************************************************************
        //  Go to Checkout
        // ***********************************************************
        $I->click(['css' => '.cart__buttons-single > button:nth-child(1)']);
        $I->see('Shipping');
        $I->wait(4);
    }

    public function _BenefitFR(\Guidance\Tests\Project\Actor $I)
    {

        $I->amOnUrl('https://www.benefitcosmetics.com/fr-fr/');

        // Click Accept Cookies Popup
       // $I->see('Cookies');
        $I->click(['css' => '#onetrust-accept-btn-handler']);
        $I->wait(4);


        // ****************************
        // Sign In
        //  *******************************
        $I->moveMouseOver(['css' => '.account-popup__link > span:nth-child(1)']);    //  .account-popup__link > span:nth-child(1)
        $I->wait(4);
        $I->fillField(['id' => 'login_form_email'], 'wayne.hazle@guidance.com');
        // $I->wait(3);
        $I->fillField(['id' => 'login_form_password'], '@Testing123');
       // $I->wait(2);
        $I->click(['css' => 'button.btn:nth-child(4)']);
        $I->wait(4);

        // *****************************************************************************
        //  GO TO MY ACCOUNT -
        // ***********************************************************
        //$I->amOnPage('/account');
        $I->amOnUrl('https://www.benefitcosmetics.com/fr-fr/account');
        $I->waitForText('profil', 30); // secs
        $I->see('profil');

        // *****************************************************************************
        //  SEARCH from HOMEPAGE -
        // ***********************************************************
        // $I->amOnPage('/');
        $I->amOnUrl('https://www.benefitcosmetics.com/fr-fr/');
        $I->fillField(['css' => '#search-input'], 'Eye');
        $I->wait(2);
        $I->pressKey(['css' => '#search-input'],\Facebook\WebDriver\WebDriverKeys::ENTER);
        $I->waitForText('Eye', 30); // secs
        $I->see('Eye');

        // *****************************************************************************
        //  GO TO PLP - Editor's Pick & Apply a filter
        // ***********************************************************
        // 2. Go to Simple SHOP ALL PLP page----------------------------------------------------------------------------
        //$I->amOnPage('/brow-makeup');
        $I->amOnUrl('https://www.benefitcosmetics.com/fr-fr/brow-makeup');
        $I->waitForText('Brow', 30); // secs
        $I->see('Brow');

        $I->click(['css' => '#ac-0 > button:nth-child(1)']);
        $I->wait(1);
        $I->click(['css' => '#filter-20']);
        $I->wait(3);

        // *****************************************************************************
        //  Go to a PDP and Add to Cart
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/fr-fr/product/precisely-my-brow-eyebrow-pencil?product=PRECI-FULL&sku=BM19');
        $I->waitForText('Brow', 30); // secs
        $I->see('Brow');

        // Change count ...
       $I->click(['css' => 'form.product-info__section > div:nth-child(1) > div:nth-child(1) > button:nth-child(3)']);

        // Click Add to Cart
        $I->see('ajouter');
        $I->click(['css' => 'form.product-info__section > button:nth-child(2)']);
        $I->waitForText('panier', 30); // secs
        $I->see('panier');

        // *****************************************************************************
        //  Go to Checkout
        // ***********************************************************
        $I->click(['css' => '.cart__buttons-single > button:nth-child(1)']);
        $I->waitForText('Adresse', 30); // secs
        $I->see('Adresse');

    }



    public function _BenefitUKEnglish(\Guidance\Tests\Project\Actor $I)
    {

        $I->amOnUrl('https://www.benefitcosmetics.com/en-gb/');
        $I->maximizeWindow();
        $I->waitForText('brows', 30); // secs
        $I->see('brows');

        // Click Accept Cookies Popup
        $I->see('Cookies');
        $I->click(['css' => '#onetrust-accept-btn-handler']);
        $I->wait(4);

        // ****************************
        // Sign In
        //  *******************************
        $I->moveMouseOver(['css' => '.icon-arrow-down:nth-child(2)']);
        $I->wait(6);
        $I->fillField(['id' => 'login_form_email'], 'wayne.hazle@guidance.com');
        $I->wait(3);
        $I->fillField(['id' => 'login_form_password'], '@Testing123');
        $I->wait(2);
        $I->click(['css' => 'button.btn:nth-child(4)']);
        $I->wait(4);

        // *****************************************************************************
        //  GO TO MY ACCOUNT -
        // ***********************************************************

       // $I->amOnPage('/account');
        $I->amOnUrl('https://www.benefitcosmetics.com/en-gb/account');
        $I->waitForText('profile', 30); // secs
        $I->see('profile');

        // *****************************************************************************
        //  SEARCH from HOMEPAGE -
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-gb/');
        $I->fillField(['css' => '#search-input'], 'Eye');
        $I->wait(6);
        $I->pressKey(['css' => '#search-input'],\Facebook\WebDriver\WebDriverKeys::ENTER);
        $I->waitForText('eye', 30); // secs
        $I->see('eye');


        // *****************************************************************************
        //  GO TO PLP - Editor's Pick & Apply a filter
        // ***********************************************************
        // 2. Go to Simple SHOP ALL PLP page----------------------------------------------------------------------------
        $I->amOnUrl('https://www.benefitcosmetics.com/en-gb/brow-makeup');
        $I->waitForText('brows', 30); // secs
        $I->see('brow');

        // Click Price Filter
        $I->click(['css' => '#ac-0 > button:nth-child(1)']);
        $I->wait(1);
        $I->click(['css' => '#filter-30']);
        $I->wait(5);

        // *****************************************************************************
        //  Go to a PDP and Add to Cart
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-gb/product/24-hour-brow-setter-clear-brow-gel?product=24HOUBM66-FULL&sku=BM66/');
        $I->see('Brow');

        // Change count
        $I->click(['css' => 'form.product-info__section > div:nth-child(1) > div:nth-child(1) > button:nth-child(3)']);

        // Click Add to Cart
        $I->see('Add to Cart');
        $I->click(['css' => 'form.product-info__section > button:nth-child(2)']);
        //$I->waitForText('Added to cart!');
        $I->wait(4);

        // *****************************************************************************
        //  Go to Checkout
        // ***********************************************************
        $I->click(['css' => '.cart__buttons-single > button:nth-child(1)']);
        $I->amOnUrl('https://www.benefitcosmetics.com/en-gb/checkout#/');
        $I->waitForText('Shipping', 30); // secs
        $I->see('Shipping');
        $I->wait(4);
    }


    public function _BenefitAustraliaEnglish(\Guidance\Tests\Project\Actor $I)
    {
        // *****************************************************
        //  BRAND SITE - No account abilities. Minimum products
        // *****************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/');
        $I->maximizeWindow();
        $I->waitForText('brows', 30); // secs
        $I->see('brows');

        // Click Accept Cookies Popup
        //$I->see('Cookies');
        //$I->click(['css' => '#onetrust-accept-btn-handler']);
        //$I->wait(4);

        // *****************************************************************************
        //  GO TO Store Locator
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/find-a-store');
        $I->waitForText('store', 30); // secs
        $I->see('store');

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/bestsellers');
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');


        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/brows');
        $I->waitForText('brow', 30); // secs
        $I->see('brow');


        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/services');
        $I->waitForText('doors', 30); // secs
        $I->see('doors');


        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/offers-more');
        $I->waitForText('book', 30); // secs
        $I->see('book');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://au.benefitbrows.com/ReserveCounter.aspx');
        $I->see('date');
        $I->wait(4);

        //  CLICK MENUS instead of going directly to URLS
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/');


        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(2) > a:nth-child(1)']);
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(3) > a:nth-child(1)']);
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(4) > a:nth-child(1)']);
        $I->waitForText('services', 30); // secs
        $I->see('services');


        // *****************************************************************************
        //  GO TO Book A Service
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(5) > a:nth-child(1)']);
        $I->waitForText('date', 30); // secs
        $I->see('date');
        $I->amOnUrl('https://www.benefitcosmetics.com/en-au/');

        // *****************************************************************************
        //  GO TO Find a Store
        // ***********************************************************
        $I->click(['css' => 'a.link:nth-child(2)']);
        $I->waitForText('store', 30); // secs
        $I->see('store');


    }

    public function _BenefitCanadaEnglish(\Guidance\Tests\Project\Actor $I)
    {
        // *****************************************************
        //  BRAND SITE - No account abilities. Minimum products
        // *****************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/');
        $I->maximizeWindow();
        $I->waitForText('brows', 30); // secs
        $I->see('brows');

        // Click Accept Cookies Popup
        //$I->see('Cookies');
        //$I->click(['css' => '#onetrust-accept-btn-handler']);
        //$I->wait(4);

        // *****************************************************************************
        //  GO TO Store Locator
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/find-a-store');
        $I->waitForText('store', 30); // secs
        $I->see('store');

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/bestsellers');
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/brows');
        $I->waitForText('brow', 30); // secs
        $I->see('brow');


        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/services');
        $I->waitForText('doors', 30); // secs
        $I->see('doors');

        // *****************************************************************************
        //  GO TO Offers More
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/offers-more');
        $I->waitForText('book', 30); // secs
        $I->see('book');

        // *****************************************************************************
        //  GO TO Book a Service
        // ***********************************************************
        $I->amOnUrl('https://sephora.benefitbrowbars.com/en');
        $I->waitForText('wait', 30); // secs
        $I->see('wait');
        $I->wait(4);

        //  CLICK MENUS instead of going directly to URLS
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/');
        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(2) > a:nth-child(1)']);
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(3) > a:nth-child(1)']);
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(4) > a:nth-child(1)']);
        $I->waitForText('services', 30); // secs
        $I->see('services');


        // *****************************************************************************
        //  GO TO Book A Service
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(5) > a:nth-child(1)']);
        $I->waitForText('wait', 30); // secs
        $I->see('wait');
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ca/');

        // *****************************************************************************
        //  GO TO Find a Store
        // ***********************************************************
        $I->click(['css' => 'a.link:nth-child(2)']);
        $I->waitForText('store', 30); // secs
        $I->see('store');


    }

    public function _BenefitPhillipinesEnglish(\Guidance\Tests\Project\Actor $I)
    {
        // *****************************************************
        //  BRAND SITE - No account abilities. Minimum products
        // *****************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ph/');
        $I->maximizeWindow();
        $I->waitForText('brows', 30); // secs

        // Click Accept Cookies Popup
        //$I->see('Cookies');
        //$I->click(['css' => '#onetrust-accept-btn-handler']);
        //$I->wait(4);

        // *****************************************************************************
        //  GO TO Store Locator
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ph/find-a-store');
        $I->waitForText('store', 30); // secs
        $I->see('store');

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ph/bestsellers');
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ph/brows');
        $I->waitForText('brow', 30); // secs
        $I->see('brow');
        $I->wait(4);

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ph/services');
        $I->waitForText('brow', 30); // secs
        $I->see('service');
        $I->wait(4);

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ph/offers-more');
        $I->waitForText('services', 30); // secs
        $I->see('services');
        $I->wait(4);

        //  CLICK MENUS instead of going directly to URLS

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(2) > a:nth-child(1)']);
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(3) > a:nth-child(1)']);
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(4) > a:nth-child(1)']);
        $I->waitForText('services', 30); // secs
        $I->see('services');


        // *****************************************************************************
        //  GO TO Find a Store
        // ***********************************************************
        $I->click(['css' => 'a.link:nth-child(2)']);
        $I->waitForText('store', 30); // secs
        $I->see('store');


    }


    public function _BenefitHongKongEnglish(\Guidance\Tests\Project\Actor $I)
    {
        // *****************************************************
        //  BRAND SITE - No account abilities. Minimum products
        // *****************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/');
        $I->maximizeWindow();
        $I->waitForText('brows', 30); // secs
        $I->see('brows');

        // Click Accept Cookies Popup
        //$I->see('Cookies');
        //$I->click(['css' => '#onetrust-accept-btn-handler']);
        //$I->wait(4);

        // *****************************************************************************
        //  GO TO Store Locator
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/find-a-store');
        $I->waitForText('store', 30); // secs
        $I->see('store');

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/bestsellers');
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/brows');
        $I->waitForText('brows', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/services');
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/offers-more');
        $I->waitForText('services', 30); // secs
        $I->see('services');

        // *****************************************************************************
        //  GO TO Book A Service
        // ***********************************************************
        $I->amOnUrl('https://hk.benefitbrows.com/ReserveCounter.aspx');
        $I->wait(5);
        $I->click(['css' => '.mfp-close']);
        $I->waitForText('KOWLOON', 30); // secs
        $I->see('KOWLOON');

        //  CLICK MENUS instead of going directly to URLS
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/');

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(2) > a:nth-child(1)']);
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(3) > a:nth-child(1)']);
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(4) > a:nth-child(1)']);
        $I->waitForText('services', 30); // secs
        $I->see('services');

        // *****************************************************************************
        //  GO TO Book A Service
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(5) > a:nth-child(1)']);
       // $I->wait(4);
        // $I->click(['css' => '.mfp-close']);
        $I->waitForText('KOWLOON', 30); // secs
        $I->see('KOWLOON');

        // *****************************************************************************
        //  GO TO Find a Store
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-hk/');
        $I->waitForText('brows', 30); // secs
        $I->click(['css' => 'a.link:nth-child(2)']);
        $I->waitForText('store', 30); // secs
        $I->see('store');

    }


    public function _BenefitIrelandEnglish(\Guidance\Tests\Project\Actor $I)
    {
        // *****************************************************
        //  BRAND SITE - No account abilities. Minimum products
        // *****************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ie/');
        $I->maximizeWindow();
        $I->waitForText('brows', 30); // secs
        $I->see('brows');

        // Click Accept Cookies Popup
        //$I->see('Cookies');
        //$I->click(['css' => '#onetrust-accept-btn-handler']);
        //$I->wait(4);

        // *****************************************************************************
        //  GO TO Store Locator
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ie/find-a-store');
        $I->waitForText('store', 30); // secs
        $I->see('store');

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ie/bestsellers');
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ie/brows');
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ie/services');
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-ie/offers-more');
        $I->waitForText('services', 30); // secs
        $I->see('services');


        //  ****************  CLICK MENUS instead of going directly to URLS  *********************

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(2) > a:nth-child(1)']);
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(3) > a:nth-child(1)']);
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(4) > a:nth-child(1)']);
        $I->waitForText('services', 30); // secs
        $I->see('services');

        // *****************************************************************************
        //  GO TO Find a Store
        // ***********************************************************
        $I->click(['css' => 'a.link:nth-child(2)']);
        $I->waitForText('store', 30); // secs
        $I->see('store');
    }

    public function _BenefitMalaysiaEnglish(\Guidance\Tests\Project\Actor $I)
    {
        // *****************************************************
        //  BRAND SITE - No account abilities. Minimum products
        // *****************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-my/');
        $I->waitForText('brows', 30); // secs
        $I->see('brows');
        $I->maximizeWindow();

        // Click Accept Cookies Popup
        //$I->see('Cookies');
        //$I->click(['css' => '#onetrust-accept-btn-handler']);
        //$I->wait(4);

        // *****************************************************************************
        //  GO TO Store Locator
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-my/find-a-store');
        $I->waitForText('store', 30); // secs
        $I->see('store');

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-my/bestsellers');
        $I->waitForText('bestseller', 30); // secs
        $I->see('bestseller');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-my/brows');
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-my/services');
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->amOnUrl('https://www.benefitcosmetics.com/en-my/offers-more');
        $I->waitForText('services', 30); // secs
        $I->see('services');

        //  CLICK MENUS instead of going directly to URLS

        // *****************************************************************************
        //  GO TO Best Sellers
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(1) > a:nth-child(1)']);
        $I->waitForText('bestsellers', 30); // secs
        $I->see('bestsellers');

        // *****************************************************************************
        //  GO TO Brows
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(2) > a:nth-child(1)']);
        $I->waitForText('brow', 30); // secs
        $I->see('brow');

        // *****************************************************************************
        //  GO TO Services
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(3) > a:nth-child(1)']);
        $I->waitForText('service', 30); // secs
        $I->see('service');

        // *****************************************************************************
        //  GO TO Offers and More
        // ***********************************************************
        $I->click(['css' => '.desktop-menu > ul:nth-child(1) > li:nth-child(4) > a:nth-child(1)']);
        $I->waitForText('services', 30); // secs
        $I->see('services');

        // *****************************************************************************
        //  GO TO Find a Store
        // ***********************************************************
        $I->click(['css' => 'a.link:nth-child(2)']);
        $I->waitForText('store', 30); // secs
        $I->see('store');

    }
    // ########################################
}