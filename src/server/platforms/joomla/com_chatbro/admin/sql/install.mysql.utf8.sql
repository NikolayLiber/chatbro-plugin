INSERT INTO `#__viewlevels` (title, ordering, rules)
SELECT 'ChatBro View', 0, '[]'
FROM dual
WHERE NOT EXISTS (SELECT 1
FROM `#__viewlevels`
WHERE title = 'View Chat');

INSERT INTO `#__viewlevels` (title, ordering, rules)
SELECT 'Ban Chat User', 0, '[]'
FROM dual
WHERE NOT EXISTS (SELECT 1
FROM `#__viewlevels`
WHERE title = 'Ban Chat User');

INSERT INTO `#__viewlevels` (title, ordering, rules)
SELECT 'Delete Chat Messages', 0, '[]'
FROM dual
WHERE NOT EXISTS (SELECT 1
FROM `#__viewlevels`
WHERE title = 'Delete Chat Messages');
