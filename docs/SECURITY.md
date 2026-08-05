# Bezpieczeństwo

## Zakres motywu

Gun Resort One nie przyjmuje, nie wysyła i nie zapisuje danych rezerwacji. Formularz, terminy, płatności i dane osobowe należą do zewnętrznego operatora otwieranego zwykłym odnośnikiem HTTPS.

## Treści i uprawnienia

- edycję szablonów i części motywu należy ograniczyć do zaufanych administratorów lub redaktorów;
- WordPress powinien być aktualizowany do najnowszej stabilnej wersji;
- konto administratora powinno używać silnego hasła i MFA po stronie dostawcy;
- przed większymi zmianami należy wykonać kopię bazy i test na środowisku stagingowym;
- nie należy publikować danych osobowych pracowników ani informacji o zabezpieczeniach obiektu bez uzasadnienia.

## Migracja

Migrator używa wyłącznie standardowych API WordPressa, sprawdza uprawnienie `edit_theme_options` i wykonuje przełączenie strony startowej jako ostatni krok. Stare dane pozostają w bazie do rollbacku.

Treści źródłowe są escapowane przy budowaniu bloków. Błąd zapisu zatrzymuje migrację, pozostawia dotychczasową stronę aktywną i pokazuje administratorowi komunikat.

## Zewnętrzne odnośniki

Adres rezerwacji powinien używać HTTPS i prowadzić do zweryfikowanego operatora. Po zmianie operatora należy sprawdzić przekierowania, politykę prywatności, regulamin oraz zakres przekazywanych danych.

## Zgłaszanie problemów

Nie publikuj szczegółów podatności w publicznym issue. Skontaktuj się prywatnie z właścicielem repozytorium i podaj wersję motywu, wersję WordPressa, sposób odtworzenia oraz możliwy wpływ problemu.
