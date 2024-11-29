-- Adminer 4.8.1 PostgreSQL 13.2 (Debian 13.2-1.pgdg100+1) dump

DROP TABLE IF EXISTS "orders";
DROP SEQUENCE IF EXISTS orders_id_seq;
CREATE SEQUENCE orders_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."orders" (
    "id" integer DEFAULT nextval('orders_id_seq') NOT NULL,
    "order_number" character varying(255) NOT NULL,
    "weight" double precision NOT NULL,
    "city_ref" character varying(255) NOT NULL,
    "delivery_type" character varying(255) NOT NULL,
    "branch_ref" character varying(255) NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "orders_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "orders" ("id", "order_number", "weight", "city_ref", "delivery_type", "branch_ref", "created_at") VALUES
(1,	'324234234',	0.2,	'Харків',	'Відділення',	'169227f4-e1c2-11e3-8c4a-0050568002cf',	'2024-11-29 21:22:55.973923');

-- 2024-11-29 21:24:24.447263+00
