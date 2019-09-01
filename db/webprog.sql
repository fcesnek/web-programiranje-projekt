-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2019 at 06:08 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webprog`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `synopsis` varchar(1000) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `genre` varchar(50) NOT NULL,
  `year` char(4) NOT NULL,
  `numPages` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `image`, `synopsis`, `isbn`, `genre`, `year`, `numPages`) VALUES
(19, 'Memoirs of a Geisha', ' Arthur Golden', 'uploads/953-195-068-7.jpg', ' A literary sensation and runaway bestseller, this brilliant debut novel presents with seamless authenticity and exquisite lyricism the true confessions of one of Japan\'s most celebrated geisha.\r\n\r\nIn Memoirs of a Geisha, we enter a world where appearances are paramount; where a girl\'s virginity is auctioned to the highest bidder; where women are trained to beguile the most powerful men; and where love is scorned as illusion. It is a unique and triumphant work of fiction - at once romantic, erotic, suspenseful - and completely unforgettable.', '953-195-068-7', 'Historical Fiction', '1997', 434),
(20, 'Lord of the Flies', 'William Golding', 'uploads/953-6450-14-3.jpg', 'At the dawn of the next world war, a plane crashes on an uncharted island, stranding a group of schoolboys. At first, with no adult supervision, their freedom is something to celebrate; this far from civilization the boys can do anything they want. Anything. They attempt to forge their own society, failing, however, in the face of terror, sin and evil. And as order collapses, as strange howls echo in the night, as terror begins its reign, the hope of adventure seems as far from reality as the hope of being rescued. Labeled a parable, an allegory, a myth, a morality tale, a parody, a political treatise, even a vision of the apocalypse, Lord of the Flies is perhaps our most memorable novel about â€œthe end of innocence, the darkness of manâ€™s heart.â€', '953-6450-14-3', 'Fiction', '1954', 182),
(21, 'Anna Karenina', ' Leo Tolstoy', 'uploads/953-7160-58-0.jpg', 'Acclaimed by many as the world\'s greatest novel, Anna Karenina provides a vast panorama of contemporary life in Russia and of humanity in general. In it Tolstoy uses his intense imaginative insight to create some of the most memorable characters in all of literature. Anna is a sophisticated woman who abandons her empty existence as the wife of Karenin and turns to Count Vronsky to fulfil her passionate nature - with tragic consequences. Levin is a reflection of Tolstoy himself, often expressing the author\'s own views and convictions.\r\n\r\nThroughout, Tolstoy points no moral, merely inviting us not to judge but to watch. As Rosemary Edmonds comments, \'He leaves the shifting patterns of the kaleidoscope to bring home the meaning of the brooding words following the title, \'Vengeance is mine, and I will repay.', '953-7160-58-0', 'Fiction', '1877', 964),
(22, 'The Book Thief', 'Markus Zusak', 'uploads/978-953-12-0756-0.jpg', 'It is 1939. Nazi Germany. The country is holding its breath. Death has never been busier, and will be busier still.\r\n\r\nBy her brother\'s graveside, Liesel\'s life is changed when she picks up a single object, partially hidden in the snow. It is The Gravedigger\'s Handbook, left behind there by accident, and it is her first act of book thievery. So begins a love affair with books and words, as Liesel, with the help of her accordian-playing foster father, learns to read. Soon she is stealing books from Nazi book-burnings, the mayor\'s wife\'s library, wherever there are books to be found.\r\n\r\nBut these are dangerous times. When Liesel\'s foster family hides a Jew in their basement, Liesel\'s world is both opened up, and closed down.\r\n\r\nIn superbly crafted writing that burns with intensity, award-winning author Markus Zusak has given us one of the most enduring stories of our time.', '978-953-12-0756-0', 'Historical Fiction', '2005', 552),
(23, 'The Handmaid\'s Tale', 'Margaret Atwood ', 'uploads/86-343-0593-7.jpg', 'Offred is a Handmaid in the Republic of Gilead. She may leave the home of the Commander and his wife once a day to walk to food markets whose signs are now pictures instead of words because women are no longer allowed to read. She must lie on her back once a month and pray that the Commander makes her pregnant, because in an age of declining births, Offred and the other Handmaids are valued only if their ovaries are viable. Offred can remember the years before, when she lived and made love with her husband, Luke; when she played with and protected her daughter; when she had a job, money of her own, and access to knowledge. But all of that is gone now...', '86-343-0593-7', 'Science Fiction', '1985', 344),
(24, 'Jane Eyre', 'Charlotte BrontÃ«', 'uploads/978-953-178-990-5.jpg', 'Orphaned as a child, Jane has felt an outcast her whole young life. Her courage is tested once again when she arrives at Thornfield Hall, where she has been hired by the brooding, proud Edward Rochester to care for his ward AdÃ¨le. Jane finds herself drawn to his troubled yet kind spirit. She falls in love. Hard.\r\n\r\nBut there is a terrifying secret inside the gloomy, forbidding Thornfield Hall. Is Rochester hiding from Jane? Will Jane be left heartbroken and exiled once again?\r\n\r\n', '978-953-178-990-5', 'Romance', '1847', 532);

-- --------------------------------------------------------

--
-- Table structure for table `book_lists`
--

CREATE TABLE `book_lists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_lists`
--

INSERT INTO `book_lists` (`id`, `user_id`, `name`) VALUES
(33, 14, 'Favorites'),
(34, 14, 'Currently reading'),
(35, 14, 'Plan to read'),
(36, 14, 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `book_lists_books`
--

CREATE TABLE `book_lists_books` (
  `book_id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_ratings`
--

CREATE TABLE `book_ratings` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(7) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `admin` bit(1) NOT NULL DEFAULT b'0',
  `date_registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `admin`, `date_registered`) VALUES
(14, 'admin', '$2y$10$0mrY7GpzaiWJCTbpO9RGQePcz0pieU5d7/kXKORY8G1xQdkJ/hmby', b'1', '2019-09-01 18:06:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_lists`
--
ALTER TABLE `book_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `book_lists_books`
--
ALTER TABLE `book_lists_books`
  ADD KEY `book_id` (`book_id`),
  ADD KEY `list_id` (`list_id`);

--
-- Indexes for table `book_ratings`
--
ALTER TABLE `book_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `book_lists`
--
ALTER TABLE `book_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `book_ratings`
--
ALTER TABLE `book_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_lists`
--
ALTER TABLE `book_lists`
  ADD CONSTRAINT `book_lists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `book_lists_books`
--
ALTER TABLE `book_lists_books`
  ADD CONSTRAINT `book_lists_books_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `book_lists_books_ibfk_2` FOREIGN KEY (`list_id`) REFERENCES `book_lists` (`id`);

--
-- Constraints for table `book_ratings`
--
ALTER TABLE `book_ratings`
  ADD CONSTRAINT `book_ratings_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
