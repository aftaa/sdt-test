-- a
select name from clients c
where
    c.id not in (
        select customer_id
        from orders
        where order_date > date_sub(now(), interval 7 day)
    );


-- a с левым объединением
select c.name 
    from clients c left join orders o on c.id = customer_id
    and order_date > date_sub(now(), interval 7 day)
where o.id is null;


-- b
select name
from clients c join orders o on c.id = o.customer_id
group by c.id
order by count(o.id) desc
limit 5;


-- c
select c.name
from clients c
    join orders on c.id = orders.customer_id
    join merchandise m on orders.item_id = m.id
group by c.id
order by sum(m.price) desc
limit 10;


-- d
select distinct m.name
from merchandise as m
    join orders o on m.id = o.item_id
where o.status <> 'complete'
group by m.id;


/* добавленные индексы */

-- a добавлен индекс по полю order_date, т.к. оно участвует в предложении where
alter table orders add index order_date_index (order_date);

-- d добавлен индекс по полю order_status, т.к. оно участвует в предложении where
alter table orders add index order_status_index (order_date);

-- по полям orders.item_id & orders.customer_id индексы уже построены при создании внешних ключей
