-- Adminer 4.8.1 PostgreSQL 13.2 (Debian 13.2-1.pgdg100+1) dump

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."users" (
    "id" integer DEFAULT nextval('users_id_seq') NOT NULL,
    "username" character varying(50) NOT NULL,
    "email" character varying(100) NOT NULL,
    "password" character varying(255) NOT NULL,
    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "users" ("id", "username", "email", "password") VALUES
(1,	'фівфів',	'lsadalsd@gmail.com',	'827ccb0eea8a706c4c34a16891f84e7b');

-- 2024-11-29 20:31:23.719814+00
