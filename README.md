# Wymagania systemowe

- PHP 8.2
- Composer
- MariaDB 10.4
- Node.js v22.13.1

# Instalacja

- Sklonuj repozytorium
- Zainstaluj zależności za pomocą komendy `composer install`
- Skonfiguruj plik .env.local
- Utwórz bazę danych za pomocą komendy `php bin/console doctrine:database:create`
- Wykonaj migracje za pomocą komendy `php bin/console doctrine:migrations:migrate`
- w katalogu public utwórz katalog uploads
- w katalogu public wykonaj komende npm install

# Uruchomienie

- Załaduj dane testowe za pomocą komendy `php bin/console doctrine:fixtures:load`
- Uruchom serwer deweloperski za pomocą komendy `symfony server:start`
- Aplikacja dostępna jest pod adresem `http://localhost:8000`

# Strurktura Programu

## założenia

- Marża obliczana jest na podstawie ceny netto
- Sposób realizacji obliczania marży zależny jest od ustawień w konfiguracji (.env zmienna STORAGE_MARGIN_TYPE może być
  wartość percentage lub value)


- Unikalność "Klienta" sprawdzana jest na podstawie numeru telefonu
- Unikalność "Usługi" sprawdzana jest na podstawie Id
- Unikalność "Części" sprawdzana jest na podstawie nazwy części
- Unikalność "Stawki VAT" sprawdzana jest na podstawie wartości stawki VAT i nazwy stawki VAT

- Encja "RealisedService" reprezentuje obiekt realizowanej usługi, realizowana usługa jest na rzecz encji Klient (many
  to
  one relacja) i może mieć encje service attachment- załączniki do usługi np. zdjęcia.

# Do zrobienia

- Dodać generowanie odebrania.
- Marża może być również w formie wartości np. 10 zł
- Do widoku marki dodać możliwość dodawania modeli
- Dodać Marki i modele do części
- Opublikować projekt na web
- Dodać kamerę do usługi do dodawania
- Przycisk zrób zdjęcie nie znika po zrobieniu zdjęcia
- Zrobić refactor OrderController - usunąć powtarzający się kod
- Napisać testy jednostkowe i end to end za pomocą playwritha
- dodać możliwości obsługi klientów firmowych
- dodać możliwość dodawania załączników do magazynu (np. zdjęcia)
- refactor na Onion Architecture!
- zrobienie ajaxa do dodawania załączników do usługi
- zrobienie ajaxa do dodawania załączników do magazynu
- walidacja Formularzy
- Opisać w README.md jak zainstalować projekt
- Opisać w README.md jakie założenia przyjęto przy tworzeniu projektu dla encji RealisedServiceUsedItem
- Statystyki wykonanych usług i sprzedaży części
- Wysyłka powiadomień email i sms

# Przydatne komendy

php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load