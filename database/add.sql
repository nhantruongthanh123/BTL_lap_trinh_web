USE bookstore_db;

INSERT INTO orders (user_id, total_amount, shipping_fee, final_amount, status, payment_status, order_number, shipping_address) VALUES
(3, 145000, 15000, 160000, 'shipping', 'unpaid', 'ORD-2025-002', '456 Lê Lợi, TP.HCM');

INSERT INTO order_items (order_id, book_id, quantity, price, subtotal) VALUES
(2, 2, 1, 85000, 85000),
(2, 3, 1, 60000, 60000);
