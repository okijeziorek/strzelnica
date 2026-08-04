# Gun Resort One

Dynamiczny, responsywny motyw WordPress typu one-page przeznaczony dla obiektu łączącego strzelnicę, ofertę wydarzeń, gastronomię oraz noclegi.

Projekt został zaprojektowany tak, aby treści biznesowe nie były wpisane na stałe w szablonach PHP. Oferta, usługi formularza, zalety, karty promocyjne i cennik są zarządzane z panelu WordPressa, natomiast dane globalne oraz komunikaty można edytować w Personalizatorze.

## Najważniejsze cechy

- responsywny układ typu one-page;
- edytowalne logo i nazwa witryny;
- edytowalna sekcja główna;
- własne typy wpisów dla zalet, kart oferty, usług i cennika;
- formularz zapytania rezerwacyjnego;
- dynamiczna lista usług pobierana z panelu;
- wysyłanie wiadomości przez `wp_mail()`;
- walidacja po stronie serwera;
- zabezpieczenie nonce i pole honeypot;
- menu WordPress z możliwością przypisania własnych odnośników;
- podstawowe mechanizmy dostępności;
- obsługa urządzeń mobilnych;
- ustawienia kontaktowe, prawne i społecznościowe w Personalizatorze.

## Wymagania

- WordPress 6.0 lub nowszy;
- PHP 7.4 lub nowszy;
- działająca funkcja wysyłania poczty albo skonfigurowany serwer SMTP;
- zalecany certyfikat HTTPS;
- dostęp administratora do panelu WordPressa.

## Instalacja

1. Pobierz repozytorium albo przygotuj archiwum ZIP zawierające pliki motywu.
2. Umieść katalog motywu w `wp-content/themes/`.
3. W panelu WordPressa przejdź do `Wygląd → Motywy`.
4. Aktywuj motyw **Gun Resort One**.
5. Przejdź do `Wygląd → Dostosuj` i uzupełnij ustawienia globalne.
6. Dodaj treści w sekcjach administracyjnych: `Zalety`, `Karty oferty`, `Usługi` i `Cennik`.
7. Przypisz menu do lokalizacji `Menu główne` i opcjonalnie `Menu w stopce`.
8. Skonfiguruj pocztę wychodzącą i wykonaj próbne wysłanie formularza.

Szczegółowe kroki znajdują się w [dokumentacji instalacji](docs/INSTALLATION.md).

## Zarządzanie treścią

### Zalety

Każdy wpis typu `Zaleta` tworzy pojedynczą kartę w sekcji zalet. Tytuł jest nagłówkiem, treść opisem, obrazek wyróżniający grafiką, a kolejność można ustalać polem kolejności.

### Karty oferty

Wpisy typu `Karta oferty` tworzą duże boksy ofertowe, przykładowo restaurację, hotel albo wydarzenia. Obsługiwane są tytuł, treść, zajawka, obraz wyróżniający i kolejność.

### Usługi

Wpisy typu `Usługa` zasilają formularz rezerwacyjny. Tytuł opublikowanej usługi pojawia się na liście wyboru i jest jednocześnie dozwoloną wartością sprawdzaną przez backend.

### Cennik

Wpisy typu `Pozycja cennika` tworzą kolejne wiersze cennika. Tytuł wpisu powinien zawierać nazwę pozycji, a zajawka cenę albo inny komunikat handlowy.

Więcej informacji: [model treści](docs/CONTENT-MODEL.md).

## Konfiguracja globalna

W `Wygląd → Dostosuj → Treść strony i komunikaty` można ustawić między innymi:

- nagłówek i opis sekcji głównej;
- etykiety przycisków;
- teksty formularza;
- komunikaty powodzenia i błędu;
- telefon, e-mail, adres i godziny otwarcia;
- adres odbiorcy rezerwacji;
- opis w stopce;
- odnośniki do mapy, regulaminu, cookies i mediów społecznościowych;
- teksty używane przez menu mobilne;
- zdjęcie główne.

Pełny opis pól znajduje się w [dokumentacji konfiguracji](docs/CONFIGURATION.md).

## Formularz rezerwacyjny

Formularz nie tworzy obecnie rezerwacji w bazie danych. Wysyła zapytanie e-mailowe do skonfigurowanego odbiorcy.

Walidowane są:

- metoda `POST`;
- nonce WordPressa;
- pole antyspamowe;
- imię i nazwisko;
- telefon albo adres e-mail;
- zgodność usługi z opublikowanymi wpisami `Usługa`;
- data od dnia bieżącego do dwóch lat naprzód;
- format godziny;
- długość wiadomości.

Szczegóły: [bezpieczeństwo](docs/SECURITY.md).

## Struktura projektu

```text
.
├── 404.php
├── dynamic.php
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── index.php
├── main.css
├── page.php
├── single.php
├── style.css
├── theme.js
├── theme.json
└── docs/
```

Opis odpowiedzialności poszczególnych plików znajduje się w [dokumentacji architektury](docs/ARCHITECTURE.md).

## Stan projektu

Projekt jest działającym prototypem motywu. Przed wdrożeniem produkcyjnym należy przeprowadzić testy na prawdziwej instalacji WordPressa, sprawdzić wysyłkę poczty, responsywność, dostępność, uprawnienia administratorów oraz zgodność treści prawnych z działalnością właściciela witryny.

Niezaimplementowane obecnie:

- kalendarz dostępności;
- zapis rezerwacji do bazy;
- płatności internetowe;
- konta klientów;
- panel obsługi rezerwacji;
- automatyczne potwierdzenia i przypomnienia;
- ograniczanie liczby żądań na poziomie aplikacji;
- automatyczne testy i ciągła integracja.

## Rozwój

Zasady rozwoju, testowania i pracy z gałęziami opisano w [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md).

## Licencja

Kod motywu deklaruje licencję GNU General Public License v2 lub nowszą. Przed dystrybucją należy osobno sprawdzić licencje wszystkich zdjęć, ikon, fontów i pozostałych zasobów graficznych.