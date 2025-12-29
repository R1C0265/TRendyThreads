-- CMS Content Management Database
-- For dynamic website content management

-- About Section Content
CREATE TABLE `about_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` text,
  `description` text NOT NULL,
  `video_url` varchar(500),
  `image_path` varchar(255),
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- About Features/Points
CREATE TABLE `about_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon_class` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
);

-- Background Images Management
CREATE TABLE `background_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(100) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255),
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_name` (`section_name`)
);

-- Services Management
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon_class` varchar(100),
  `icon_color` varchar(20) DEFAULT '#0dcaf0',
  `link_url` varchar(500),
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- Clients/Partners Management
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `website_url` varchar(500),
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- Contact Information
CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('address','phone','email','map') NOT NULL,
  `label` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `icon_class` varchar(100),
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
);

-- Hero Section Content
CREATE TABLE `hero_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` text,
  `cta_text` varchar(100),
  `cta_link` varchar(500),
  `background_image` varchar(255),
  `hero_image` varchar(255),
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- Stats/Counters
CREATE TABLE `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `value` int(11) NOT NULL,
  `icon_class` varchar(100),
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
);

-- Insert Sample Data
INSERT INTO `about_content` (`title`, `subtitle`, `description`, `video_url`, `image_path`) VALUES
('About Us', 'Creating Amazing Experiences', 'Dolor iure expedita id fuga asperiores qui sunt consequatur minima. Quidem voluptas deleniti. Sit quia molestiae quia quas qui magnam itaque veritatis dolores.', 'https://www.youtube.com/watch?v=Y7f98aduVJ8', 'assets/img/about.jpg');

INSERT INTO `about_features` (`icon_class`, `title`, `description`, `sort_order`) VALUES
('bi bi-diagram-3', 'Ullamco laboris nisi ut aliquip consequat', 'Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade', 1),
('bi bi-fullscreen-exit', 'Magnam soluta odio exercitationem reprehenderi', 'Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi', 2),
('bi bi-broadcast', 'Voluptatem et qui exercitationem', 'Et velit et eos maiores est tempora et quos dolorem autem tempora incidunt maxime veniam', 3);

INSERT INTO `background_images` (`section_name`, `image_path`, `alt_text`) VALUES
('hero', 'assets/img/hero-bg.jpg', 'Hero Background'),
('stats', 'assets/img/stats-bg.jpg', 'Stats Background'),
('testimonials', 'assets/img/testimonials-bg.jpg', 'Testimonials Background');

INSERT INTO `services` (`title`, `description`, `icon_class`, `icon_color`, `sort_order`) VALUES
('Web Development', 'Professional website development with modern technologies', 'bi bi-code-slash', '#0dcaf0', 1),
('Digital Marketing', 'Comprehensive digital marketing solutions for your business', 'bi bi-megaphone', '#fd7e14', 2),
('E-commerce Solutions', 'Complete online store setup and management', 'bi bi-cart', '#20c997', 3),
('Mobile Apps', 'Native and cross-platform mobile application development', 'bi bi-phone', '#df1529', 4);

INSERT INTO `contact_info` (`type`, `label`, `value`, `icon_class`, `sort_order`) VALUES
('address', 'Address', 'Zaison Shopping Center, Lilongwe, Area 25', 'bi bi-geo-alt', 1),
('phone', 'Call Us', '+1 5589 55488 55', 'bi bi-telephone', 2),
('email', 'Email Us', 'info@trendythreads.com', 'bi bi-envelope', 3),
('map', 'Map', 'https://maps.google.com/maps?q=-13.8673703,33.7597532&t=&z=15&ie=UTF8&iwloc=&output=embed', '', 4);

INSERT INTO `hero_content` (`title`, `subtitle`, `cta_text`, `cta_link`, `background_image`, `hero_image`) VALUES
('CREATING WEBSITES THAT MAKE YOU STOP & STARE', 'We are team of talented designers making websites with Bootstrap', 'Get Started', '#about', 'assets/img/hero-bg.jpg', 'assets/img/hero-img.png');

INSERT INTO `stats` (`label`, `value`, `sort_order`) VALUES
('Clients', 232, 1),
('Projects', 521, 2),
('Hours Of Support', 1453, 3),
('Workers', 32, 4);