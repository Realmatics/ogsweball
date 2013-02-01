<?php if (!defined('IN_PHPBB')) exit; ?>Subject: phpBB erfolgreich installiert

Herzlichen Glückwunsch!

Du hast phpBB erfolgreich auf deinem Server installiert.

Diese E-Mail enthält wichtige Informationen über deine Installation, die du gut aufbewahren solltest. Dein Passwort wurde sicher in unserer Datenbank gespeichert und kann nicht wiederhergestellt werden. Falls es vergessen werden sollte, kannst du es über die E-Mail-Adresse, die deinem Account zugeordnet ist, zurücksetzen lassen.

----------------------------
Benutzername: <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>


URL des Boards: <?php echo (isset($this->_rootref['U_BOARD'])) ? $this->_rootref['U_BOARD'] : ''; ?>

----------------------------

Hilfreiche Informationen über die phpBB-Software können im docs-Ordner deiner Installation und auf der Website der phpBB Group — http://www.phpbb.com/support/ — gefunden werden. Eine deutschsprachige Anlaufstelle findest du unter http://www.phpbb.de/.

Um die Sicherheit deines Boards zu gewährleisten, empfehlen wir dir dringend, es immer auf der aktuellen Version zu halten. Damit du entsprechende Informationen zeitnah erhältst, kann auf den oben genannten Seite ein Newsletter abonniert werden.

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>