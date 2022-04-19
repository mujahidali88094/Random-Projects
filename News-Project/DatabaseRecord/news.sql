-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2022 at 11:15 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Sports'),
(2, 'Business'),
(4, 'Politics'),
(5, 'Technology'),
(16, 'New'),
(3, 'Entertainment');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` int(100) NOT NULL,
  `post_date` date NOT NULL,
  `author` int(11) NOT NULL,
  `post_img` varchar(30) NOT NULL DEFAULT 'post_1.jpg'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `description`, `category`, `post_date`, `author`, `post_img`) VALUES
(1, 'Pakistan\'s key role in Afghanistan echoes in US Congress', 'Pakistan will decide Afghanistan’s future as the United States only has a minor role now in the country after almost 20 years of uninterrupted military presence.\r\n\r\nThis claim by Afghan President Ashraf Ghani echoed in the US Congress this week, where lawmakers from both Republican and Democratic parties expressed concern about Afghanistan’s future after the withdrawal of American and Nato forces and deliberated on the key role that must be played by Pakistan in this regard.\r\n\r\nThe Biden administration plans to withdraw all foreign troops from Afghanistan by September 11, almost 20 years after the first US troops arrived in the country.\r\n\r\nRead: US wants Taliban, Kabul to jointly combat ISIS\r\n\r\nIn an interview with German publication Der Spiegel earlier this week, President Ghani had said that bringing peace to Afghanistan now was “first and foremost a matter of getting Pakistan on board” and the withdrawal would greatly reduce America’s influence in the country.\r\n\r\n“The US now plays only a minor role. The question of peace or hostility is now in Pakistani hands,” he had claimed.', 4, '2021-05-20', 2, 'echoes.jpg'),
(2, 'Babar Azam beats Virat Kohli\'s record, becomes fastest batsman to reach 2,000 runs in T20Is', 'Pakistan captain Babar Azam on Sunday became the fastest cricket player to reach the milestone of 2,000 runs in the Twenty20 international format, having accomplished the feat in just 52 innings.\r\n\r\nAzam bagged the record during Pakistan\'s deciding third and final T20 against Zimbabwe at the Harare Sports Club.\r\n\r\n\"The brilliant Babar Azam bags another record,\" congratulated the Pakistan Cricket Board (PCB) on Twitter.\r\nThe International Cricket Council (ICC) also congratulated Azam on the achievement.\r\n\r\n\"Babar Azam becomes the fastest batsman to 2000 T20I runs. He has taken only 52 innings to achieve the feat!\"', 1, '2021-04-25', 3, 'babar2000runs.jpg'),
(3, 'ELON MUSK VOWS LOYALTY TO DOGECOIN AND CAUSES VALUE TO SHOOT UP 15% IN LATEST CRYPTOCURRENCY SHAKEUP', 'Elon Musk vowed his loyalty to Dogecoin and caused its value to shoot up 15 per cent in the latest Cryptocurrency shakeup.\r\n\r\nThe billionaire entrepreneur responded to a Twitter thread speculating on his Dogecoin holdings by saying, “I haven’t and won’t sell any.”\r\n\r\nThat caused the cryptocurrency, which Mr Musk has regularly promoted on social media, to sharply jump in value after days of slumping in price.\r\n\r\n\r\nIsrael and Hamas agree Gaza ceasefire\r\nEarlier Mr Musk, the CEO of Tesla and SpaceX, had posted a picture on Twitter of a laptop with a sticker of a one dollar bill on it, and the caption “How much is that Doge in the window.”\r\n\r\nAnd when social media users looked closer, the dollar bill had an image of the Doge Shiba Inu dog on it in the place of George Washington.\r\n\r\nRecommended\r\nElon Musk says he is about to deliver ‘fastest production car ever’ in Tesla Model S Plaid\r\nElon Musk says he is about to deliver ‘fastest production car ever’ in Tesla Model S Plaid\r\nSpaceX, Amazon, and OneWeb’s mega-constellations risk huge collisions in games of ‘chicken’, new report warns\r\nSpaceX, Amazon, and OneWeb’s mega-constellations risk huge collisions in games of ‘chicken’, new report warns\r\nCrypto price news – live: Bitcoin crash halted after Elon Musk says Tesla has ‘diamond hands’\r\nCrypto price news – live: Bitcoin crash halted after Elon Musk says Tesla has ‘diamond hands’\r\n\r\nIt is the second time this week that Mr Musk has publicly come to the defence of cryptocurrencies, after tweeting out that Tesla would hold on to its Bitcoin as the market crashed.\r\n\r\nHe had come under criticism from social media users , some of whom suggested he had sold his Bitcoin holdings at the top of the market.\r\n\r\nHe responded by tweeting out that the electric car company had “Diamond hands”, in reference to traders who hold onto stocks as their price drop with the goal of longterm profit.\r\n\r\nThe slide in crypto values started after Mr Musk tweeted that Tesla was suspending taking Bitcoin as payment for its vehicles because of concerns of the environmental impact of Bitcoin mining.\r\n\r\nHe has since said that the company will hold its Bitcoin and allow its use for purchases again when the mining is more sustainable.\r\n\r\n\r\nThe Cambridge Centre for Alternative Finance has estimated that the annual energy consumption of the Bitcoin industry is on a par with that of a country the size of Malaysia.\r\n\r\n\r\nPrince William launches scathing attack on BBC ‘lies’ over Bashir’s Diana interview\r\nAnd that most of the mining operations are based in areas of China that produces cheap electricity using coal-fired power plants.\r\n\r\nTesla bought $1.5bn worth of Bitcoin at the end of 2020 when the price was under $20,000 and sold of 10 per cent in early 2021 when the price topped $50,000 for a profit of $101m.\r\n\r\nWhen he appeared on Saturday Night Live last month he repeatedly plugged Dogecoin and jokingly called it a “hustle” during one sketch.\r\n\r\n', 2, '2021-05-21', 4, 'bitcoin.jpg'),
(4, 'Robert Downey Jr. says he had to alter his attitude entirely to earn Iron Man role', 'American actor Robert Downey Jr. is known far and wide for his role in the Marvel Cinematic Universe as Iron Man.\r\n\r\nThe Dolittle, 56, star had revealed how he had to completely alter his attitude towards acting in order to bag the superhero role of Tony Stark aka Iron Man.\r\n\r\nIn an interview with Howard Stern, Downey Jr. revealed: “There was a part of me that was saying, ‘My world view has to change if I want to really have a shot.’”\r\n\r\n“If I’m not on my side for this going my way, why should anybody else be?” he added.\r\n\r\nThe Sherlock Holmes star was then asked by Stern if he “willed” himself to alter his attitude. Responding to that, the actor nodded but also claimed that the change in attitude isn’t what really made the difference.\r\n\r\n“I had to psych myself into [the idea that] nobody else on Earth had a chance,” he said.\r\n\r\nRegarding his beliefs about confidence, Downey Jr. said: “Obviously [the audition] went pretty well. But that’s the funny thing about confidence … The incorrect amount of it, and nothing will ever happen,” he added. ', 3, '2021-04-14', 5, 'rdj.jpg'),
(10, 'Summer spotlight - OPPO Enco Air true wireless earphones officially released', 'LAHORE - OPPO Acoustics unveiled its latest addition to the OPPO Enco line with the new OPPO Enco Air True Wireless Earphones. With their eye-catching design, high-quality audio, convenient touch controls, and user-focused features, the PKR 8999 earphones are a definite contender for the summer’s hottest new upcoming wireless audio product.\r\n\r\nThe OPPO Enco Air is the world’s first true wireless earphones to receive a High-Performance/Low Latency Certificate for True Wireless Earphones from the world-renowned German technical testing company TÜV Rheinland — successfully passing the company’s comprehensive earphone testing and certification system. OPPO Enco Air’s ability to be the first of its kind to obtain this certificate proves the earphone’s remarkable performance isn’t just words, but also independently verifiable.', 5, '2021-05-26', 2, 'oppo-enco.jpg'),
(14, 'Army chief calls on PM Shehbaz Sharif', 'ISLAMABAD: Prime Minister Shehbaz Sharif on Tuesday met Chief of Army Staff General Qamar Javed Bajwa.\r\n\r\nThis was their first meeting after the premier was elected to the office.\r\n\r\n\"Professional matters pertaining to national security were discussed during the meeting,\" a statement from the Prime Minister\'s Office said.', 4, '2022-04-19', 9, 'CM_Punjab_Shehbaz_Sharif.jpg'),
(6, '‘Loki’: He’s Unpredictable, Arrogant, and Doing Great in Latest Spot', 'The Original Series arrives June 9 with new episodes streaming Wednesdays on Disney+.\r\nWhat else do you expect from the God of Mischief? In the latest TV Spot for Marvel Studios’ Loki, the titular character tries to fit in, and possibly change his ways, at the Time Variance Authority — aka, the TVA. But try as he might, it’s hard for Loki just to shed his old ways of being insubordinate, stubborn, unpredictable, and above all, arrogant. You can’t just stop being burdened with glorious purpose, you know?\r\n\r\n“Unbelievable, wherever you go it’s just death, destruction, the literal ends of worlds,” Mobius M. Mobius remarks to him, to which Loki retorts, smugly as always, “I know?” \r\n\r\nFind a brand new look at the upcoming Disney+ original series above, and have you heard? Wednesdays are the new Fridays, with Loki set to premiere on Wednesday, June 9. \r\nLoki features the God of Mischief as he steps out of his brother’s shadow in a new series that takes place after the events of Marvel Studios\' Avengers: Endgame. Tom Hiddleston returns as the title character, joined by Owen Wilson, Gugu Mbatha-Raw, Sophia Di Martino, Wunmi Mosaku and Richard E. Grant. Kate Herron directs Loki, and Michael Waldron is head writer.', 3, '2021-05-05', 4, 'loki.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'normal'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `username`, `password`, `role`) VALUES
(1, 'Mujahid', 'Ali', 'mujahidali', '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
(2, 'The', 'Nation', 'thenation', '92517f5d2193d546c191ca1678e20930', 'normal'),
(3, 'The', 'Dawn', 'thedawn', 'e7b339a5c6ec33d6e2522dec405a5ae6', 'normal'),
(4, 'Independant', '', 'independant', '764ab5804c912bc11da010aee9dfa17a', 'normal'),
(5, 'News', 'International', 'newsinternational', '94e4c3ce17fb0420456812d5790d26dd', 'normal'),
(6, 'CNN', '', 'cnn', 'ff7a4157153a8077212c8757fd39b8bd', 'normal'),
(8, 'Geo', 'News', 'geonews', 'f96d7956bff75d05a22e902e13a16f37', 'normal'),
(9, 'Saad', 'Qayyum', 'saadii', '81dc9bdb52d04dc20036dbd8313ed055', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_id` (`post_id`),
  ADD KEY `category` (`category`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
