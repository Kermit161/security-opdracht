-- Database: `shop`

-- --------------------------------------------------------

-- Tabelstructuur voor tabel `category`
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Gegevens voor tabel `category`
INSERT INTO `category` (`id`, `name`) VALUES
(1, 'schoen'),
(2, 'jas');

-- --------------------------------------------------------

-- Tabelstructuur voor tabel `product`
CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `productCode` varchar(10) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Gegevens voor tabel `product`
INSERT INTO `product` (`id`, `name`, `description`, `productCode`, `price`, `category_id`) VALUES
(1, 'Trench coat', 'blauw M', '11234503NB', 527.99, 1),
(2, 'Teddy jas', 'groen M', '11534503YG', 114.65, 1),
(3, 'bomber jack', 'bomber jack large Navy Green', '44124304NG', 125.89, 1);

-- --------------------------------------------------------

-- Tabelstructuur voor tabel `user`
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  CONSTRAINT `unique_email` UNIQUE (`email`)  -- Unique email constraint
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Gegevens voor tabel `user`
-- Password should be hashed, use PHP's password_hash() function
-- The following is just a sample entry. Replace the password with a hashed value.
INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'Test user', 'test@test.nl', 'hashed_password_here');  -- Replace with hashed password

-- --------------------------------------------------------

-- Indexen voor tabel `category`
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

-- Indexen voor tabel `product`
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

-- Indexen voor tabel `user`
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT instellingen voor de tabellen
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;
