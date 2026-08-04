# Instalacja i pierwsze uruchomienie

## 1. Wymagania środowiska

Minimalne wymagania deklarowane przez motyw:

- WordPress 6.0 lub nowszy;
- PHP 7.4 lub nowszy;
- MySQL albo MariaDB zgodna z wymaganiami używanej wersji WordPressa;
- serwer HTTP Apache lub Nginx;
- możliwość wysyłania poczty przez `wp_mail()`;
- uprawnienia administratora WordPressa.

Dla wdrożenia publicznego zaleca się HTTPS, kopie zapasowe, środowisko testowe i SMTP z uwierzytelnieniem.

## 2. Instalacja z katalogu

1. Pobierz repozytorium.
2. Zmień nazwę katalogu na czytelną, przykładowo `gun-resort-one`.
3. Skopiuj katalog do:

```text
wp-content/themes/gun-resort-one
```

4. Zaloguj się do panelu WordPressa.
5. Wejdź w `Wygląd → Motywy`.
6. Aktywuj **Gun Resort One**.

## 3. Instalacja z archiwum ZIP

Archiwum musi zawierać katalog motywu, a w nim bezpośrednio plik `style.css`.

Poprawna struktura:

```text
gun-resort-one.zip
└── gun-resort-one/
    ├── style.css
    ├── functions.php
    ├── front-page.php
    └── ...
```

Następnie:

1. przejdź do `Wygląd → Motywy → Dodaj nowy`;
2. wybierz `Wyślij motyw na serwer`;
3. wskaż archiwum ZIP;
4. zainstaluj i aktywuj motyw.

## 4. Ustawienia witryny

W `Ustawienia → Ogólne` ustaw:

- tytuł witryny;
- opis witryny;
- adres WordPressa i witryny;
- strefę czasową;
- format daty i godziny;
- język witryny;
- administracyjny adres e-mail.

Strefa czasowa ma znaczenie dla walidacji dat formularza.

## 5. Strona główna

Motyw posiada `front-page.php`. W typowej instalacji WordPress użyje go jako widoku strony głównej.

Po aktywacji sprawdź `Ustawienia → Czytanie`. Jeżeli używana jest statyczna strona główna, wybierz właściwą stronę. Motyw nie wymaga jednak wpisywania treści biznesowych w edytorze tej strony — sekcje pobierane są z Personalizatora i własnych typów wpisów.

## 6. Menu

1. Przejdź do `Wygląd → Menu`.
2. Utwórz nowe menu.
3. Dodaj własne odnośniki do sekcji, przykładowo:

```text
/#oferta
/#pakiety
/#cennik
/#rezerwacja
/#kontakt
```

4. Przypisz menu do lokalizacji `Menu główne`.
5. Opcjonalnie utwórz osobne menu dla lokalizacji `Menu w stopce`.

## 7. Uzupełnienie treści

Po aktywacji w panelu powinny pojawić się pozycje:

- Zalety;
- Karty oferty;
- Usługi;
- Cennik.

Dodaj i opublikuj co najmniej:

- jedną usługę, aby formularz miał dostępną wartość;
- jedną pozycję cennika;
- jedną zaletę;
- jedną kartę oferty.

Kolejność elementów zależy od pola kolejności wpisu, a następnie od daty publikacji.

## 8. Personalizator

Przejdź do `Wygląd → Dostosuj → Treść strony i komunikaty` i uzupełnij wszystkie używane pola. Puste pola mogą powodować brak etykiet albo brak danych kontaktowych na stronie.

Szczegóły pól opisano w `CONFIGURATION.md`.

## 9. Poczta wychodząca

WordPress używa funkcji `wp_mail()`. Sama poprawna odpowiedź funkcji nie dowodzi, że wiadomość została dostarczona do skrzynki odbiorczej.

Zalecany przebieg:

1. zainstaluj sprawdzoną wtyczkę SMTP;
2. skonfiguruj konto nadawcze;
3. ustaw SPF, DKIM i DMARC dla domeny;
4. wykonaj test poczty;
5. wyślij próbny formularz;
6. sprawdź skrzynkę odbiorczą i folder spam.

## 10. Kontrola po instalacji

Sprawdź:

- stronę główną na komputerze i telefonie;
- otwieranie i zamykanie menu mobilnego;
- wszystkie odnośniki;
- listę usług w formularzu;
- walidację błędnych pól;
- wysyłkę poprawnego zgłoszenia;
- komunikat powodzenia i błędu;
- stronę 404;
- pojedynczy wpis i zwykłą stronę;
- logo, faviconę i tytuł karty;
- politykę prywatności oraz pozostałe dokumenty prawne.

## 11. Aktualizacja motywu

Przed aktualizacją wykonaj kopię plików i bazy danych. Treści zapisane jako wpisy oraz ustawienia Personalizatora znajdują się w bazie, ale ręczne zmiany w plikach motywu zostaną nadpisane przy zastąpieniu katalogu.

Zmiany niestandardowe należy w przyszłości przenosić do motywu potomnego albo rozwijać w repozytorium, a nie edytować bezpośrednio w panelowym edytorze plików.