# Bezpieczeństwo

## Zakres

Dokument opisuje zabezpieczenia obecne w motywie oraz działania wymagane przed wdrożeniem produkcyjnym. Motyw nie zastępuje konfiguracji bezpieczeństwa całego WordPressa, serwera, poczty ani infrastruktury.

## Zabezpieczenia formularza

### Metoda żądania

Obsługa formularza akceptuje wyłącznie metodę `POST`. Inne metody kończą się przekierowaniem ze statusem błędu.

### Nonce

Formularz zawiera nonce WordPressa. Backend sprawdza go przez `wp_verify_nonce()`. Chroni to przed częścią żądań CSRF, lecz nonce nie jest mechanizmem uwierzytelniania użytkownika ani zabezpieczeniem antyspamowym.

### Honeypot

Ukryte pole `company` powinno pozostać puste. Jego wypełnienie jest traktowane jako aktywność automatyczna.

Honeypot może ograniczyć prosty spam, ale nie zatrzyma botów analizujących formularze.

### Sanitizacja

Dane wejściowe są przetwarzane przez:

- `wp_unslash()`;
- `sanitize_text_field()`;
- `sanitize_textarea_field()`;
- `sanitize_email()`;
- `sanitize_key()`.

### Walidacja kontaktu

Pole kontaktowe akceptuje prawidłowy adres e-mail albo numer telefonu zgodny z wyrażeniem regularnym. Walidacja formatu nie potwierdza, że adres lub numer rzeczywiście istnieje.

### Walidacja usługi

Wartość usługi musi odpowiadać tytułowi jednego z aktualnie opublikowanych wpisów `gro_service`. Nie należy ufać wartości wysłanej przez przeglądarkę bez tego porównania.

### Walidacja daty i godziny

Data musi:

- odpowiadać formatowi `Y-m-d`;
- przypadać nie wcześniej niż bieżący dzień;
- przypadać nie później niż dwa lata od bieżącego dnia.

Godzina musi odpowiadać formatowi 24-godzinnemu `HH:MM`.

Walidacja nie sprawdza godzin otwarcia, dni wolnych ani dostępności terminów.

### Ograniczenie długości

Wiadomość jest ograniczona do 2000 znaków. Dla pozostałych pól należy utrzymywać ograniczenia również w HTML i po stronie serwera.

## Wysyłanie poczty

Wiadomości są wysyłane jako tekst zwykły. Odbiorca pochodzi z ustawienia motywu i musi przejść walidację e-maila.

Należy skonfigurować:

- SMTP z uwierzytelnieniem;
- SPF;
- DKIM;
- DMARC;
- poprawny adres nadawcy w domenie witryny;
- rejestrowanie błędów dostarczenia bez zapisywania nadmiernych danych osobowych.

## Dane osobowe

Formularz może przetwarzać imię, nazwisko, telefon, e-mail, termin i treść wiadomości. Przed uruchomieniem publicznym należy ustalić:

- administratora danych;
- podstawę prawną przetwarzania;
- okres przechowywania;
- odbiorców danych;
- treść obowiązku informacyjnego;
- sposób realizacji praw osoby;
- procedurę obsługi naruszeń;
- zasady dostępu pracowników do skrzynki.

Motyw nie dodaje automatycznie checkboxa zgody ani pełnego obowiązku informacyjnego. Wymagane rozwiązanie zależy od konkretnego procesu i podstawy prawnej.

## Brak rate limitingu

Obecna implementacja nie ogranicza liczby zgłoszeń z jednego adresu IP, sesji ani urządzenia. Przed wdrożeniem należy rozważyć:

- ograniczanie żądań na reverse proxy lub WAF;
- zabezpieczenie formularza rozwiązaniem antybotowym;
- limit czasowy w aplikacji;
- blokowanie powtarzalnych zgłoszeń;
- monitorowanie nietypowego ruchu.

Nie należy przechowywać adresów IP dłużej, niż jest to uzasadnione celem bezpieczeństwa i polityką prywatności.

## WordPress i serwer

Zalecenia operacyjne:

- regularnie aktualizuj rdzeń, motyw i wtyczki;
- usuń nieużywane motywy oraz wtyczki;
- używaj unikalnych kont administratorów;
- włącz uwierzytelnianie wieloskładnikowe;
- ogranicz próby logowania;
- wyłącz edycję plików z panelu przez `DISALLOW_FILE_EDIT`;
- stosuj najmniejsze wymagane uprawnienia plików;
- wykonuj automatyczne kopie zapasowe;
- testuj odtwarzanie kopii;
- nie ujawniaj błędów PHP użytkownikom;
- zapisuj logi poza katalogiem publicznym;
- stosuj HTTPS i bezpieczne nagłówki HTTP.

## Escapowanie wyjścia

Dane powinny być escapowane możliwie późno, zgodnie z kontekstem:

- `esc_html()` dla tekstu;
- `esc_attr()` dla atrybutu;
- `esc_url()` dla adresu URL;
- `wp_kses_post()` dla kontrolowanego HTML.

Każda nowa funkcja renderująca powinna być sprawdzona pod tym kątem.

## Uprawnienia

Własne typy wpisów korzystają obecnie z domyślnych uprawnień wpisów. Dla produkcji warto zdefiniować osobne capability, aby redaktor cennika nie musiał otrzymywać pełnych uprawnień administratora.

## Zgłaszanie problemów

Nie należy publikować aktywnej podatności w publicznym zgłoszeniu przed przygotowaniem poprawki. Zgłoszenie powinno zawierać:

- wersję WordPressa i PHP;
- wersję motywu;
- opis wpływu;
- kroki odtworzenia;
- minimalny dowód problemu bez danych prawdziwych użytkowników;
- propozycję ograniczenia ryzyka.