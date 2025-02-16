# Wymagania systemowe

- PHP 8.2
- Composer
- MariaDB 10.4

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
-

# Do zrobienia

- Dodać generowanie przyjęcia dokumentu.
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