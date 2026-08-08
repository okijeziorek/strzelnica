# Changelog

## 2.4.0

- Utrwalono w pełni blokowy model edycji strony głównej, nagłówka, menu i stopki.
- Migracja tworzy treść startową tylko raz i nie nadpisuje późniejszych zmian zapisanych w Edytorze witryny.
- Starsza strona z migracji wcześniejszej niż 6 nadal otrzymuje jednorazowe, brakujące sekcje 2.2 bez dalszego automatycznego przepisywania treści.
- Dodano automatyczny kontrakt testowy wykrywający blokady edytora i treści spoza natywnych bloków.

## 2.3.0

- Zastąpiono roboczą ikonę przekazanym logo Gun Resort.
- Dodano właściwe adresy `kontakt@gunresort.pl` i `praca@gunresort.pl`.
- Dodano oficjalne profile Facebook i Instagram do nagłówka oraz stopki.
- Migracja 8 odświeża zapisany nagłówek istniejącej instalacji i wymusza pobranie aktualnego logo poza pamięcią podręczną CDN.

## 2.2.0

- Przebudowano stronę główną według zaakceptowanej kompozycji: szerokie hero, zalety, pakiety, trzy kroki i czterokolumnowa stopka.
- Hero korzysta z edytowalnego bloku Cover z wymianą obrazu i punktem kadrowania.
- Dodano wzorce pakietów oraz sekcji „Pierwszy raz na strzelnicy?”.
- Dodano robocze pola treści, cen i kontaktu oraz tymczasowe przejścia rezerwacji do sekcji kontaktowej.
- Migracja 6 zachowuje edytowane hero i zalety, zmienia kotwicę sekcji zalet oraz dopisuje brakujące sekcje bez duplikatów.
- Poszerzono układ do 1320 px i utrzymano cztery karty w rzędzie przy szerokości 901 px.

## 2.1.0

- Dodano rozbudowaną stopkę z potwierdzonym telefonem i lokalizacją Toruń.
- Dodano odnośnik Kontakt do nawigacji oraz poprawiono układ mobilny strony.
- Dodano domyślne logo widoczne także przed konfiguracją Logo witryny.
- Usunięto ograniczenie 760 px z wnętrza hero i siatki zalet, przywracając proporcje obrazu oraz cztery kolumny na desktopie.
- Dopasowano górny pasek do pełnej szerokości nagłówka i ustawiono kadr zdjęcia hero na prawą stronę.
- Dodano styl „Ukryj element” dla linków nawigacji i przycisków.
- Aktualizacja migracji wykorzystuje istniejące obiekty, zachowuje zmiany wykonane w edytorze i nie tworzy duplikatów.
- Rezerwacje pozostają poza WordPressem; tymczasowe akcje kontaktowe korzystają z telefonu.

## 2.0.0

- Przebudowano motyw na natywny motyw blokowy WordPressa.
- Dodano pełną edycję nagłówka, hero, przycisków i kafelków w edytorze blokowym.
- Dodano wzorce hero oraz czterech kafelków bez blokad edytora.
- Dodano bezpieczną, idempotentną migrację ustawień, zalet i menu z wersji 1.x.
- Ukryto historyczne typy treści, zachowując dane do migracji i rollbacku.
- Pozostawiono rezerwacje wyłącznie jako opcjonalny link do operatora zewnętrznego.
- Podniesiono wymagania do WordPressa 7.0 i PHP 8.2.
- Dodano WordPress Coding Standards, walidację CI i budowę instalowalnego ZIP-a.

## 1.1.0

- Dopracowano wygląd względem dostarczonej makiety.
- Dodano edycję treści przez Personalizer i własne typy wpisów.
- Dodano zewnętrzny odnośnik rezerwacji.

## 1.0.1

- Poprawiono odnośniki, menu i dostępność.
