-- convert Laravel migrations to raw SQL scripts --

-- migration:2014_10_12_000000_create_users_table --
create table `users` (
  `id` bigint unsigned not null auto_increment primary key, 
  `name` varchar(255) not null, 
  `code` varchar(255) null, 
  `contract_date` timestamp not null, 
  `email` varchar(255) not null, 
  `email_verified_at` timestamp null, 
  `password` varchar(255) not null, 
  `remember_token` varchar(100) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table 
  `users` 
add 
  unique `users_email_unique`(`email`);

-- migration:2023_08_17_000000_create_addresses_table --
create table `addresses` (
  `id` bigint unsigned not null auto_increment primary key, 
  `street` varchar(255) null, 
  `city` varchar(255) null, 
  `postal_code` varchar(255) null, 
  `created_at` timestamp null, 
  `updated_at` timestamp null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- migration:2023_08_18_000000_create_address_user_table --
create table `address_user` (
  `user_id` bigint unsigned not null, 
  `address_id` bigint unsigned not null
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
