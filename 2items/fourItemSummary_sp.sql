
create procedure fourItemsSummary
as

declare @splitname nchar(25);

set @splitname = (
select
 splitname 
from fourItems
where 
oldest = (select max(oldest)from fouritems)
)

select
	max(inqueue) as Waiting,
cast((cast(max(oldest) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(max(oldest) as int)%60) as varchar(2)),2) as Oldest,
max(oldest) as oldest_ss,
max(available) as Available,
@splitname as split
from fourItems

go