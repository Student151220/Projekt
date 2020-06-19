-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Cze 2020, 20:48
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `biblioteka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `autor`
--

CREATE TABLE `autor` (
  `id_autora` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `autor`
--

INSERT INTO `autor` (`id_autora`, `imie`, `nazwisko`) VALUES
(9, 'Jan', 'Brzechwa'),
(10, 'Stefan', 'Żeromski'),
(11, 'Henryk', 'Sienkiewicz'),
(12, 'Adam', 'Mickiewicz');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `gatunek`
--

CREATE TABLE `gatunek` (
  `id_gatunku` int(11) NOT NULL,
  `gatunek` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `gatunek`
--

INSERT INTO `gatunek` (`id_gatunku`, `gatunek`) VALUES
(1, 'Komedia'),
(2, 'Dramat'),
(3, 'Komedia');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ksiazka`
--

CREATE TABLE `ksiazka` (
  `id_ksiazki` int(11) NOT NULL,
  `tytul` text COLLATE utf8_polish_ci NOT NULL,
  `id_autora` int(11) NOT NULL,
  `id_gatunku` int(11) NOT NULL,
  `id_wydawnictwa` int(11) NOT NULL,
  `ilosc_egz` int(11) NOT NULL,
  `ilosc_dost_egz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `ksiazka`
--

INSERT INTO `ksiazka` (`id_ksiazki`, `tytul`, `id_autora`, `id_gatunku`, `id_wydawnictwa`, `ilosc_egz`, `ilosc_dost_egz`) VALUES
(1, 'W pustyni i w puszczy', 9, 1, 2, 30, 29),
(2, 'I że Cię nie opuszczę', 9, 1, 3, 40, 40),
(3, 'feddd', 10, 3, 3, 20, 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacja`
--

CREATE TABLE `rezerwacja` (
  `id_rezerwacji` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `data_rezerwacji` date NOT NULL,
  `data_odebrania` date NOT NULL,
  `czy_odebrana` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `rezerwacja`
--

INSERT INTO `rezerwacja` (`id_rezerwacji`, `id_ksiazki`, `id_uzytkownika`, `data_rezerwacji`, `data_odebrania`, `czy_odebrana`) VALUES
(36, 1, 4, '2020-06-19', '2020-06-20', 'tak');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rola`
--

CREATE TABLE `rola` (
  `id_roli` int(11) NOT NULL,
  `rola` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rola`
--

INSERT INTO `rola` (`id_roli`, `rola`) VALUES
(1, 'administrator'),
(2, 'czytelnik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownika` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `data_ur` date NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `telefon` int(11) NOT NULL,
  `id_roli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownika`, `imie`, `nazwisko`, `data_ur`, `email`, `login`, `haslo`, `telefon`, `id_roli`) VALUES
(2, 'Jan', 'Kowalski', '1980-12-20', 'jkowalski@gmail.com', 'jkowalski', '123', 888222555, 1),
(4, 'Adam', 'Nowak', '1980-12-20', 'adam.nowak@gmail.com', 'czytelnik1', '123', 123456789, 2),
(5, 'Asd', 'Asdd', '1995-02-28', 'asd@gmail.com', 'aaa', '123', 1122334444, 2),
(6, 'asa', 'asa', '2020-05-19', 'asas', 'aaaa', '123', 0, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydawnictwo`
--

CREATE TABLE `wydawnictwo` (
  `id_wydawnictwa` int(11) NOT NULL,
  `wydawnictwo` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wydawnictwo`
--

INSERT INTO `wydawnictwo` (`id_wydawnictwa`, `wydawnictwo`) VALUES
(2, 'Dragon'),
(3, 'IBIS'),
(4, 'Wydawnictwo Otwarte'),
(5, 'Wilgaaa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenie`
--

CREATE TABLE `wypozyczenie` (
  `id_wypozyczenia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `id_ksiazki` int(11) NOT NULL,
  `data_wypozyczenia` date NOT NULL,
  `data_oddania` date NOT NULL,
  `czy_oddana` varchar(3) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wypozyczenie`
--

INSERT INTO `wypozyczenie` (`id_wypozyczenia`, `id_uzytkownika`, `id_ksiazki`, `data_wypozyczenia`, `data_oddania`, `czy_oddana`) VALUES
(10, 4, 1, '2020-05-28', '2020-05-28', 'tak'),
(11, 4, 1, '2020-06-19', '2020-07-19', 'nie');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id_autora`);

--
-- Indeksy dla tabeli `gatunek`
--
ALTER TABLE `gatunek`
  ADD PRIMARY KEY (`id_gatunku`);

--
-- Indeksy dla tabeli `ksiazka`
--
ALTER TABLE `ksiazka`
  ADD PRIMARY KEY (`id_ksiazki`),
  ADD KEY `id_autora` (`id_autora`),
  ADD KEY `id_gatunku` (`id_gatunku`),
  ADD KEY `id_wydawnictwa` (`id_wydawnictwa`);

--
-- Indeksy dla tabeli `rezerwacja`
--
ALTER TABLE `rezerwacja`
  ADD PRIMARY KEY (`id_rezerwacji`),
  ADD KEY `id_ksiazki` (`id_ksiazki`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `rola`
--
ALTER TABLE `rola`
  ADD PRIMARY KEY (`id_roli`),
  ADD KEY `id_roli` (`id_roli`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownika`),
  ADD KEY `id_roli` (`id_roli`),
  ADD KEY `id_roli_2` (`id_roli`);

--
-- Indeksy dla tabeli `wydawnictwo`
--
ALTER TABLE `wydawnictwo`
  ADD PRIMARY KEY (`id_wydawnictwa`);

--
-- Indeksy dla tabeli `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  ADD PRIMARY KEY (`id_wypozyczenia`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`),
  ADD KEY `id_ksiazki` (`id_ksiazki`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `autor`
--
ALTER TABLE `autor`
  MODIFY `id_autora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `gatunek`
--
ALTER TABLE `gatunek`
  MODIFY `id_gatunku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `ksiazka`
--
ALTER TABLE `ksiazka`
  MODIFY `id_ksiazki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `rezerwacja`
--
ALTER TABLE `rezerwacja`
  MODIFY `id_rezerwacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT dla tabeli `rola`
--
ALTER TABLE `rola`
  MODIFY `id_roli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `wydawnictwo`
--
ALTER TABLE `wydawnictwo`
  MODIFY `id_wydawnictwa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  MODIFY `id_wypozyczenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `ksiazka`
--
ALTER TABLE `ksiazka`
  ADD CONSTRAINT `ksiazka_ibfk_1` FOREIGN KEY (`id_wydawnictwa`) REFERENCES `wydawnictwo` (`id_wydawnictwa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ksiazka_ibfk_2` FOREIGN KEY (`id_autora`) REFERENCES `autor` (`id_autora`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ksiazka_ibfk_3` FOREIGN KEY (`id_gatunku`) REFERENCES `gatunek` (`id_gatunku`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `rezerwacja`
--
ALTER TABLE `rezerwacja`
  ADD CONSTRAINT `rezerwacja_ibfk_1` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazka` (`id_ksiazki`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `rezerwacja_ibfk_2` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id_uzytkownika`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`id_roli`) REFERENCES `rola` (`id_roli`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  ADD CONSTRAINT `wypozyczenie_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id_uzytkownika`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `wypozyczenie_ibfk_2` FOREIGN KEY (`id_ksiazki`) REFERENCES `ksiazka` (`id_ksiazki`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
