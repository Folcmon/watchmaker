#Strurktura Programu

- Encja RealisedService reperezentuje obiekt realizowanej usługi, realizowana usługa jest na rzecz encji Klient (many to
  one relacja) i może mieć encje service attachment - załączniki do usługi np zdjęcia.
-

# Do zrobienia

- Storage stawka vat z encji brana
- Użyte części sie nie wyświetlają w widoku realizowanej usługi
- dodać możliwość dodawania załączników do magazynu (np zdjęcia)
- zrobienie ajaxa do dodawania załączników do usługi
- zrobienie ajaxa do dodawania załączników do magazynu
- walidacja Formularzy
- Opisać w README.md jak zainstalować projekt
- Opisać w README.md jakie założenia przyjęto przy tworzeniu projektu dla encji RealisedServiceUsedItem

# Przydatne komendy

php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load