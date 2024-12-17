# Strurktura Programu

## założenia

- Marża obliczana jest na podstawie ceny netto


- Unikalność "Klienta" sprawdzana jest na podstawie numeru telefonu
- Unikalność "Usługi" sprawdzana jest na podstawie Id
- Unikalność "Części" sprawdzana jest na podstawie nazwy części
- Unikalność "Stawki VAT" sprawdzana jest na podstawie wartości stawki VAT i nazwy stawki VAT

- Encja "RealisedService" reprezentuje obiekt realizowanej usługi, realizowana usługa jest na rzecz encji Klient (many
  to
  one relacja) i może mieć encje service attachment- załączniki do usługi np. zdjęcia.
-

# Do zrobienia
- Dodać kamerę do usługi do dodawania 
- Dodać generowanie przyjęcia dokumentu.
- Napisać testy jednostkowe i end to end za pomocą playwritha
- dodać możliwości obsługi klientów firmowych
- dodać możliwość dodawania załączników do magazynu (np zdjęcia)
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