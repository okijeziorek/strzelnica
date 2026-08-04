# Model treści

## Założenia

Treści biznesowe są przechowywane jako wpisy WordPressa albo ustawienia Personalizatora. Dzięki temu właściciel witryny może zmieniać ofertę bez edycji kodu.

## Zalety

Typ wpisu: `gro_feature`

Przeznaczenie: krótkie argumenty sprzedażowe wyświetlane w postaci kart.

Mapowanie pól:

| Pole WordPressa | Zastosowanie |
|---|---|
| Tytuł | nagłówek karty |
| Treść | opis zalety |
| Obraz wyróżniający | grafika lub ikona |
| Kolejność | pozycja na stronie |
| Status | tylko opublikowane elementy są wyświetlane |

Zalecenia:

- tytuł do około 40 znaków;
- opis jedno- lub dwuzdaniowy;
- wszystkie grafiki w podobnych proporcjach;
- kolejność ustawiana wartościami 10, 20, 30 itd.

## Karty oferty

Typ wpisu: `gro_card`

Przeznaczenie: większe sekcje przedstawiające części oferty.

Mapowanie pól:

| Pole WordPressa | Zastosowanie |
|---|---|
| Tytuł | nazwa oferty |
| Treść | pełny opis |
| Zajawka | krótka informacja dodatkowa |
| Obraz wyróżniający | zdjęcie karty |
| Kolejność | pozycja na stronie |

Przykładowe zastosowania:

- strzelnica;
- restauracja;
- hotel;
- imprezy firmowe;
- vouchery;
- szkolenia.

Kod nie powinien zakładać konkretnej nazwy karty. Znaczenie biznesowe wynika z treści wpisu.

## Usługi

Typ wpisu: `gro_service`

Przeznaczenie: źródło listy wyboru w formularzu.

Mapowanie pól:

| Pole WordPressa | Zastosowanie |
|---|---|
| Tytuł | wartość i etykieta usługi w formularzu |
| Treść | opis administracyjny albo treść do przyszłego użycia |
| Kolejność | kolejność na liście |
| Status | usługi opublikowane są dostępne w formularzu |

Ważne:

- backend akceptuje tylko tytuły aktualnie opublikowanych usług;
- usunięcie albo przeniesienie usługi do szkicu usuwa ją z listy;
- zmiana tytułu wpływa na treść nowych wiadomości;
- duplikaty tytułów mogą powodować niejednoznaczność;
- tytuł nie powinien zawierać danych zmiennych, takich jak cena.

## Cennik

Typ wpisu: `gro_price`

Przeznaczenie: wiersze sekcji cennika.

Mapowanie pól:

| Pole WordPressa | Zastosowanie |
|---|---|
| Tytuł | nazwa produktu lub usługi |
| Zajawka | cena albo tekst handlowy |
| Kolejność | kolejność w cenniku |
| Status | publikacja pozycji |

Przykładowa semantyka zajawki:

```text
100 zł
od 250 zł
wycena indywidualna
zapytaj o termin
```

Motyw nie wykonuje obliczeń cenowych i nie interpretuje waluty.

## Ustawienia globalne

Ustawienia Personalizatora są odpowiednie dla danych występujących w jednym miejscu albo wspólnych dla całej witryny:

- telefon;
- adres e-mail;
- adres obiektu;
- godziny otwarcia;
- obraz główny;
- teksty przycisków;
- komunikaty formularza;
- odnośniki prawne;
- odnośniki społecznościowe.

## Obrazy

Obrazy należy przechowywać w bibliotece mediów. Zalecenia:

- format WebP albo odpowiednio skompresowany JPEG;
- szerokość dopasowana do faktycznego użycia;
- brak poufnych metadanych EXIF;
- jasne nazwy plików;
- tekst alternatywny opisujący zawartość;
- potwierdzone prawa do publikacji.

## Publikacja i wersjonowanie treści

WordPress przechowuje wersje wpisów, lecz ustawienia Personalizatora nie mają równie wygodnego systemu rewizji. Przed większą zmianą ustawień zaleca się:

1. wykonanie kopii bazy danych;
2. zapisanie zrzutów ekranu ustawień;
3. wprowadzenie zmian na środowisku testowym;
4. sprawdzenie wyglądu na kilku szerokościach ekranu;
5. dopiero potem publikację na stronie właściwej.

## Przenoszenie danych

Treści wpisów można eksportować narzędziami WordPressa. Ustawienia motywu zapisane jako `theme_mods` wymagają migracji bazy, narzędzia do eksportu ustawień albo własnego skryptu migracyjnego.

Przy zmianie domeny należy wykonać bezpieczną zamianę adresów URL z obsługą serializowanych danych WordPressa.