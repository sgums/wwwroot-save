USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[llu_desktop_top]    Script Date: 1/30/2017 3:51:05 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO









CREATE procedure [dbo].[llu_desktop_top] (@grpName varchar(20))
as

--declare @grpName varchar(20);
--set @grpName = 'operations';


select top 10
splitname,
staffed,
available,
other,
waiting,
abncalls,
acdcalls,
offered,
oldest as oldest_sec,
case 
	when offered = 0 then 0
	else
		round( (100*(cast(acceptable as float) / cast(offered as float))), 1)
end as svclvl,
cast((cast(oldest as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(oldest as int)%60) as varchar(2)),2) as oldest,
case
	when acdcalls = 0 then '0:00'
	else 
		cast((cast((anstime/acdcalls) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((anstime/acdcalls) as int)%60) as varchar(2)),2)
end as asa,
case
   when acdcalls = 0 then 0
   else
      cast((anstime/acdcalls) as int)
end as asa_sec
from rt_split
where offered > 0 and
split in (select split from split_groups where param=@grpName)
order by asa_sec desc








GO

