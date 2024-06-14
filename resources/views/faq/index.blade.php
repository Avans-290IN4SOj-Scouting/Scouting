@extends('layouts.base')

@php
    $title = __('faq/faq.title');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders/main.css') }}">
@endpush

@section('content')

    <p>Je MOET deze gebruiken (staan in code)</p>
    <h1 class="text-4xl dark:text-white">h1. Preline heading</h1>
    <h2 class="text-3xl dark:text-white">h2. Preline heading</h2>
    <h3 class="text-2xl dark:text-white">h3. Preline heading</h3>
    <h4 class="text-xl dark:text-white">h4. Preline heading</h4>
    <h5 class="text-lg dark:text-white">h5. Preline heading</h5>
    <h6 class="text-base dark:text-white">h6. Preline heading</h6>

    <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="#">Link</a>

    <div>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Item</li>
        </ol>
    </div>

    <p>==================================</p>

    <h1 id="register" class="text-4xl dark:text-white">{{ __('faq/faq.h1.register') }}</h1>
    <div>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via de navigatiebalk naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('login') }}">de inlog pagina</a>.</li>
                <li>Klik op de "Registreer hier" link.</li>
                <li>Vul in het formulier je email.</li>
                <li>Kies een wachtwoord wat je wilt gebruiken voor de website en vul dat in.</li>
                <li>Klik op de registeren knop om uw account aan te maken.</li>
            </ol>
        </div>
        <br>
    </div>

    <h1 id="login" class="text-4xl dark:text-white">{{ __('faq/faq.h1.login') }}</h1>
    <div>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via de navigatiebalk naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('login') }}">de inlog pagina</a>.</li>
                <li>Vul in het formulier uw email en wachtwoord in wat u heeft gekozen bij het aanmaken van uw account.</li>
                <li>Klik op de "Log in" knop om in te loggen.</li>
            </ol>
        </div>
        <br>
    </div>

    <h1 id="account-change-details" class="text-4xl dark:text-white">{{ __('faq/faq.h1.account-change-details') }}</h1>
    <div>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via de navigatiebalk naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('profile.index') }}">de account pagina</a> door op "Mijn account" te klikken.</li>
                <li>Vul links uw huidige wachtwoord in.</li>
                <li>Kies een nieuw wachtwoord en vul dat in de resteren velden in.</li>
                <li>Klik op de "Wachtwoord wijzigen" knop om de wijziging op te slaan.</li>
            </ol>
        </div>
        <br>
    </div>


    <h1 id="account-orders" class="text-4xl dark:text-white">{{ __('faq/faq.h1.account-orders') }}</h1>
    <div>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via de navigatiebalk naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('profile.index') }}">de account pagina</a> door op "Mijn account" te klikken.</li>
                <li>U ziet standaard uw 3 meest recente bestellingen op deze pagina staan.</li>
                <li>Voor oudere bestellingen klik je op de "Bekijk al je bestellingen hier" tekst.</li>
                <li>Klik op de bestelling die wilt bekijken.</li>
            </ol>
        </div>
        <br>
    </div>

    <h1 id="product-bestellen" class="text-4xl dark:text-white scroll-mt-20"><a href="#product-bestellen">{{ __('faq/faq.h1.order-product') }}</a></h1>
    <div>
        <h2 class="text-3xl dark:text-white">Product in winkelwagen zetten</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('home') }}">de home pagina</a>.</li>
                <li>Kies de groep waar u of uw kind bij hoort.</li>
                <li>Selecteer een product.</li>
                <li>Selecteer indien nodig een andere size.</li>
                <li>Voeg het product toe aan uw winkelwagen.</li>
            </ol>
        </div>
        <br>

        <h2 class="text-3xl dark:text-white">Winkelwagen controleren</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via de navigatiebalk bovenin naar <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('orders.shoppingcart.index') }}">de winkelwagen pagina</a>.</li>
                <li>Pas indien nodig het aantal van het product aan via de "+" of "-" knop.</li>
                <li>Verwijder indien nodig het product door rechtsboven in het product op de prullenbak te klikken.</li>
            </ol>
        </div>
        <br>

        <h2 class="text-3xl dark:text-white">Bestelling plaatsen</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Klik in <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="{{ route('orders.shoppingcart.index') }}">de winkelwagen pagina</a> op de knop "Naar bestellen".</li>
                <li>Vul het naam in van het lid voor wie de bestelling is.</li>
                <li>Kies de groep van het lid in de dropdown.</li>
                <li>Klik op de "Bestelling afronden" knop.</li>
                <li>Uw bestelling is nu voldaan!</li>
            </ol>
        </div>
        <br>
    </div>

    @if (Auth::user() && (Auth::user()->hasAnyRole(['admin', 'teamleader'])))
    <h1 class="text-4xl dark:text-white">{{ __('faq/faq.h1.manage-accounts') }}</h1>
    <p>Als je deze doet voordat Delite klaar is krijg je een gele kaart :)</p>
    <br>
    @endif

    @if (Auth::user() && (Auth::user()->hasRole('admin')))
    <h1 class="text-4xl dark:text-white">{{ __('faq/faq.h1.manage-products') }}</h1>
    <div>
        <h2 id="add-product" class="text-3xl dark:text-white">Product aanmaken</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatie balk naar "Beheer producten".</li>
                <li>Klik rechtsboven op de "+" knop.</li>
                <li>Vul alle velden in behalve de prijzen.</li>
                <li>Upload een foto in het input veld.</li>
                <li>Voor de prijzen kan er door op de "Voeg extra maat toe" knop te klikken aan maat worden toegvoegd aan het product.</li>
                <li>Rechts van de prijs is een prullenbak knop waarmee je die enkele maat kan weggooien.</li>
                <li>Klik op de "Product toevoegen" knop om het product aan te maken.</li>
            </ol>
        </div>
        <br>

        <h2 class="text-3xl dark:text-white">Product Wijzigen</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatie balk naar "Beheer producten".</li>
                <li>Klik rechts in de tabel op de "Wijzig" knop bij het product wat u wilt wijzigen.</li>
                <li>Doorloop de stappen van <a class="text-blue-600 underline decoration-blue-600 hover:opacity-80" href="#add-product">product aanmaken</a>.</li>
                <li>Klik op de "Product wijzigen" knop.</li>
            </ol>
        </div>
        <br>

        <h2 class="text-3xl dark:text-white">Product Verwijderen / Inactief markeren</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatie balk naar "Beheer producten".</li>
                <li>Klik rechts in de tabel op de "Wijzig" knop bij het product wat u wilt verwijderen.</li>
                <li>Druk onderaan het formulier op de checkbox die aangeeft dat het product Momenteel inactief is.</li>
                <li>Klik op de "Product wijzigen" knop.</li>
            </ol>
        </div>
        <br>
    </div>

    <h1 class="text-4xl dark:text-white">{{ __('faq/faq.h1.manage-stock') }}</h1>
    <div>
        <h2 class="text-3xl dark:text-white">Voorraad wijzigen</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatie balk naar "Beheer voorraad".</li>
                <li>Klik in de tabel op het product waarvan u de voorraad wilt wijzigen.</li>
                <li>Klik in de uitgeklapte optie op de categorie waarvan u de voorraad wilt wijzigen.</li>
                <li>Verander per maat het aantal en klik op de "Opslaan" knop.</li>
            </ol>
        </div>
        <br>

        <h2 class="text-3xl dark:text-white">Voorraad legen</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatie balk naar "Beheer voorraad".</li>
                <li>Klik rechtsboven op de "Voorraad legen" knop.</li>
                <li>Klik in de pop-up op de "Ja, ik weet het zeker" knop.</li>
            </ol>
        </div>
        <br>
    </div>

    <h1 class="text-4xl dark:text-white">{{ __('faq/faq.h1.manage-orders') }}</h1>
    <div>
        <h2 class="text-3xl dark:text-white">Filteren</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatie balk naar "Beheer bestellingen".</li>
                <li>Linksboven staan de filter opties, alle filters kunnen in combinatie gebruikt worden.</li>
                <li>In het "Zoek op email" zoekveld wordt er gezocht op de "EMAIL" kolom uit de tabel.</li>
                <li>In de "Filter op status" dropdown wordt er gezocht op de "STATUS" kolom uit de tabel.</li>
                <li>In het "Vanaf datum" zoekveld wordt er gezocht op de "DATUM" kolom uit de tabel, hiermee worden alleen orders vanaf die datum getoond.</li>
                <li>In het "Tot datum" zoekveld wordt er gezocht op de "DATUM" kolom uit de tabel, hiermee worden alleen orders tot die datum getoond.</li>
                <li>Bepaalde kolommen in de tabel hebben een icoon naast de kolom naam, hiermee kan op alfabetische of numerieke volgorde, aflopend of oplopend gesorteerd worden voor dat veld.</li>
                <li>De filters kunnen verwijderd worden door op de "Verwijder filters" link tekst te klikken.</li>
            </ol>
        </div>

        <h2 class="text-3xl dark:text-white">Bestelstatus aanpassen</h2>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatie balk naar "Beheer bestellingen".</li>
                <li>Selecteer uit te tabel de bestelling waarvan je de status wilt wijzigen.</li>
                <li>Klik linksonder op het status veld.</li>
                <li>Verander de status met een waarde uit de dropdown.</li>
                <li>De status wordt hierna automatisch opgeslagen.</li>
            </ol>
        </div>
        <br>
    </div>


    <h1 class="text-4xl dark:text-white">{{ __('faq/faq.h1.download-backorders') }}</h1>
    <div>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Klik via het Beheer dropdown in de navigatie balk op "Download backorders".</li>
                <li>U krijgt nu een .csv bestand met alle backorders.</li>
            </ol>
        </div>
        <br>
    </div>

    <h1 class="text-4xl dark:text-white">{{ __('faq/faq.h1.godmode') }}</h1>
    <div>
        <h2 class="text-3xl dark:text-white">Bestellingen beheren</h2>
        <h3 class="text-2xl dark:text-white">Prijs aanpassen of verwijderen</h3>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatiebalk naar "Beheer bestellingen".</li>
                <li>Selecteer de bestelling die aangepast moet worden.</li>
                <li>Aan de rechterkant onder "Producten" kan de prijs aangepast worden, of verwijderd worden door op het prullenbak icoontje te klikken.</li>
            </ol>
        </div>
        <h3 class="text-2xl dark:text-white">Product toevoegen</h3>
        <div>
            <ol class="list-decimal list-inside text-gray-800 dark:text-white">
                <li>Ga via het Beheer dropdown in de navigatiebalk naar "Beheer bestellingen".</li>
                <li>Selecteer de bestelling die aangepast moet worden.</li>
                <li>Aan de rechterkant onder "Producten" staat een "Voeg product toe" knop, klik hierop.</li>
                <li>Selecteer een product uit de lijst en klik op "Voeg product toe aan bestelling".</li>
                <li>De wijziging is automatisch opgeslagen.</li>
            </ol>
        </div>
        <br>
    </div>

    <h1 class="text-4xl dark:text-white">{{ __('faq/faq.h1.promote-accounts') }}</h1>
    <div>
        <h2 class="text-3xl dark:text-white">Rol toevoegen</h2>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Klik op het plusje in een rij.</li>
            <li>Een select is verschenen, klik hierop om de selectie van rollen te zien.</li>
            <li>Na het kiezen van een rol verschijnt er een select-element; hierin kunt u een subrol specificeren. Dit is niet het geval voor de adminrol: voor de admin verschijnt er een tag.</li>
            <li>Als de gewenste rollen toegevoegd zijn, klik dan op 'opslaan'.</li>
            <li>Een modal verschijnt met alle accounts waarvan de rollen zijn aangepast. Klik op 'opslaan' om de selectie definitief op te slaan.</li>
            <li>De rollen zijn nu definitief aangepast. Dit is te zien aan de select-elementen en tags die automatisch verschijnen.</li>
        </ol>
        <h2 class="text-3xl dark:text-white">Rol verwijderen</h2>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Accounts bevatten select-elementen en tags. Deze bevatten een kruisje om ze te verwijderen.</li>
            <li>Een rol is verwijderd wanneer het select-element/tag niet meer zichtbaar is.</li>
            <li>Om de verwijdering definitief te maken, klik op 'opslaan'.</li>
            <li>Een modal verschijnt met alle accounts waarvan de rollen zijn aangepast. Klik op 'opslaan' om de selectie definitief op te slaan.</li>
            <li>De verwijderde rollen zijn niet meer te zien in de lijst.</li>
        </ol>
        <h2 class="text-3xl dark:text-white">Aanpassingen ongedaan maken</h2>
        <ol class="list-decimal list-inside text-gray-800 dark:text-white">
            <li>Als er aanpassingen zijn gemaakt voordat er is opgeslagen, kunnen deze ongedaan gemaakt worden door op de 'wijzigingen ongedaan maken' knop te drukken.</li>
            <li>De pagina zal hierna herladen. De select-elementen en tags zullen hersteld worden naar hun oorspronkelijke staat.</li>
        </ol>
    </div>
    @endif
@endsection
