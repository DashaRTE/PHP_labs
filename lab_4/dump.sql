-- Adminer 4.8.1 PostgreSQL 13.2 (Debian 13.2-1.pgdg100+1) dump

\connect "users_db";

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."users" (
    "id" integer DEFAULT nextval('users_id_seq') NOT NULL,
    "username" character varying(50) NOT NULL,
    "email" character varying(100) NOT NULL,
    "password" character varying(255) NOT NULL,
    CONSTRAINT "users_email_key" UNIQUE ("email"),
    CONSTRAINT "users_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "users_username_key" UNIQUE ("username")
) WITH (oids = false);

INSERT INTO "users" ("id", "username", "email", "password") VALUES
(1,	'Daria',	'lsadalsd@gmail.com',	'$2y$10$DY08/zdzMxxklhjg2I0PjuMULHw4LHQ5AqyAVyBr9fiy6g93UvAS2');

-- 2024-10-25 15:43:03.9181+00
