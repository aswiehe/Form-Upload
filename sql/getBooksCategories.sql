SELECT
  book_categories.categoryid,
  categories.name,
  book_categories.isbn
FROM book_categories
JOIN categories ON categories.categoryid = book_categories.categoryid;
