# Gun Resort One

[Uruchom kompletną stronę w WordPress Playground](https://playground.wordpress.net/?blueprint-url=https%3A%2F%2Fraw.githubusercontent.com%2Fokijeziorek%2Fstrzelnica%2Fmain%2Fblueprint.json)

Blueprint instaluje motyw bezpośrednio z gałęzi `main`, aktywuje go i tworzy cztery edytowalne kafelki startowe. Domyślne treści hero, branding oraz grafika są dostępne od razu po uruchomieniu.

Dynamiczny, responsywny motyw WordPress typu one-page przeznaczony dla obiektu łączącego strzelnicę, ofertę wydarzeń, gastronomię oraz noclegi.

Projekt został zaprojektowany tak, aby treści biznesowe nie były wpisane na stałe w szablonach PHP. Oferta, zalety, karty promocyjne i cennik są zarządzane z panelu WordPressa, natomiast dane globalne można edytować w Personalizatorze.

## Najważniejsze cechy

- responsywny układ typu one-page;
- edytowalne logo i nazwa witryny;
- edytowalna sekcja główna;
- własne typy wpisów dla zalet, kart oferty i cennika;
- konfigurowalny odnośnik do zewnętrznego systemu rezerwacji;
- menu WordPress z możliwością przypisania własnych odnośników;
- podstawowe mechanizmy dostępności;
- obsługa urządzeń mobilnych;
- ustawienia kontaktowe, prawne i społecznościowe w Personalizatorze.

## Wymagania

- WordPress 6.0 lub nowszy;
- PHP 7.4 lub nowszy;
- zalecany certyfikat HTTPS;
- dostęp administratora do panelu WordPressa.

## Instalacja

1. Pobierz repozytorium albo przygotuj archiwum ZIP zawierające pliki motywu.
2. Umieść katalog motywu w `wp-content/themes/`.
3. W panelu WordPressa przejdź do `Wygląd → Motywy`.
4. Aktywuj motyw **Gun Resort One**.
5. Przejdź do `Wygląd → Dostosuj` i uzupełnij ustawienia globalne.
6. Dodaj treści w sekcjach administracyjnych: `Zalety`, `Karty oferty` i `Cennik`.
7. Przypisz menu do lokalizacji `Menu główne` i opcjonalnie `Menu w stopce`.
8. Ustaw pełny adres URL zewnętrznego systemu rezerwacji i sprawdź jego działanie.

Szczegółowe kroki znajdują się w [dokumentacji instalacji](docs/INSTALLATION.md).

## Zarządzanie treścią

Wszystkie treści widoczne na stronie głównej można zmienić z panelu WordPressa:

- `Wygląd → Dostosuj → Strona główna — treść` — górny pasek, nagłówek, opis, zdjęcie główne, teksty i odnośniki przycisków oraz widoczność menu i przycisku rezerwacji;
- `Wygląd → Dostosuj → Tożsamość witryny` — nazwa strony i logo;
- `Zalety` — tytuł, opis, grafika i kolejność każdego kafelka;
- `Wygląd → Menu` — pozycje menu i ich odnośniki.

Nie trzeba edytować plików PHP ani CSS, aby zmienić treści, grafiki, liczbę kafelków lub ich kolejność.

### Zalety

Każdy wpis typu `Zaleta` tworzy pojedynczą kartę w sekcji zalet. Tytuł jest nagłówkiem, treść opisem, obrazek wyróżniający grafiką, a kolejność można ustalać polem kolejności.

### Karty oferty

Wpisy typu `Karta oferty` tworzą duże boksy ofertowe, przykładowo restaurację, hotel albo wydarzenia. Obsługiwane są tytuł, treść, zajawka, obraz wyróżniający i kolejność.

### Cennik

Wpisy typu `Pozycja cennika` tworzą kolejne wiersze cennika. Tytuł wpisu powinien zawierać nazwę pozycji, a zajawka cenę albo inny komunikat handlowy.

Więcej informacji: [model treści](docs/CONTENT-MODEL.md).

## Konfiguracja globalna

W `Wygląd → Dostosuj → Treść strony i komunikaty` można ustawić między innymi:

- nagłówek i opis sekcji głównej;
- etykiety przycisków;
- telefon, e-mail, adres i godziny otwarcia;
- etykietę i pełny adres URL zewnętrznego systemu rezerwacji;
- opis w stopce;
- odnośniki do mapy, regulaminu, cookies i mediów społecznościowych;
- teksty używane przez menu mobilne;
- zdjęcie główne.

Pełny opis pól znajduje się w [dokumentacji konfiguracji](docs/CONFIGURATION.md).

## Rezerwacje

Motyw nie przetwarza i nie przechowuje rezerwacji. Przycisk rezerwacji kieruje użytkownika do zewnętrznego systemu wskazanego w Personalizatorze. Za formularz, dostępność terminów, płatności i dane osobowe odpowiada wybrany operator zewnętrzny.

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

Projekt jest działającym prototypem motywu. Przed wdrożeniem produkcyjnym należy przeprowadzić testy na prawdziwej instalacji WordPressa, sprawdzić integrację z zewnętrzną rezerwacją, responsywność, dostępność, uprawnienia administratorów oraz zgodność treści prawnych z działalnością właściciela witryny.

Niezaimplementowane obecnie:

- konta klientów;
- automatyczne testy i ciągła integracja.

## Rozwój

Zasady rozwoju, testowania i pracy z gałęziami opisano w [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md).

## Licencja

Kod motywu deklaruje licencję GNU General Public License v2 lub nowszą. Przed dystrybucją należy osobno sprawdzić licencje wszystkich zdjęć, ikon, fontów i pozostałych zasobów graficznych.
