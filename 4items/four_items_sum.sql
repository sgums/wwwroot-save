USE [cms]
GO

/****** Object:  StoredProcedure [dbo].[fourItemsSummary]    Script Date: 10/19/2015 12:11:00 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO



ALTER procedure [dbo].[fourItemsSummary] (@grpName nchar(30) )
as

declare @splitname nchar(25);

set @splitname = (
select top 1
 splitname 
from rt_split
where 
oldest = (select max(oldest)from rt_split)
and split in (select split from split_groups where group_name=@grpName)
)

select
	max(waiting) as Waiting,
cast((cast(max(oldest) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(max(oldest) as int)%60) as varchar(2)),2) as Oldest,
max(oldest) as oldest_ss,
max(available) as Available,
case when  max(oldest) = 0 THEN ' '
	else
@splitname
end as split,
CASE 
 when sum(offered) = 0 then 100
 else cast(100*(cast(sum(acceptable) as decimal(18,2)) / cast(sum(offered) as decimal(18,2))) as decimal(18,1))
end as 'Service_Level'
from rt_split
where split in (select split from split_groups where group_name=@grpName)



GO


