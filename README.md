# AL-KASSABY

## Local setup

1. Start Apache and MySQL in XAMPP.
2. Import `schema.sql` with phpMyAdmin or run `mysql -u root < schema.sql` from this folder.
3. Copy `config.example.php` to `config.php` only if your database settings differ from the XAMPP defaults.
4. Create an admin password hash with:

   ```powershell
   C:\xampp\php\php.exe -r "echo password_hash('choose-a-strong-password', PASSWORD_DEFAULT), PHP_EOL;"
   ```

5. Insert the resulting hash in phpMyAdmin:

   ```sql
   INSERT INTO admins (username, password) VALUES ('admin', 'PASTE_THE_HASH_HERE');
   ```

Open `http://localhost/al-kassaby/login.php` to sign in.

For hosting, set `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`, and `DB_DATABASE`, or create an untracked `config.php` based on `config.example.php`.
