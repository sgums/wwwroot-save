USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[overall]    Script Date: 1/30/2017 3:52:27 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO





CREATE procedure [dbo].[overall] (@grp varchar(20))
as
--declare @grp varchar(200);
--set @grp = 'operations';

select
case 
	when sum(offered) = 0 then 0
	else
		round( (100*(sum(cast(acceptable as float)) / sum(cast((offered) as float)))), 1)
end as svclvl,
max(waiting) as waiting,
max(oldest) as oldest_seconds,
cast((cast(max(oldest) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(max(oldest) as int)%60) as varchar(2)),2) as oldest,
sum(acdcalls) as acdcalls,
sum(offered) as offered,
case
	when sum(acdcalls) = 0 then '0:00'
	else
		cast((cast((sum(acdtime)/sum(acdcalls)) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((sum(acdtime)/sum(acdcalls)) as int)%60) as varchar(2)),2)
end as att,
sum(abncalls) as abncalls,
case
	when sum(abncalls) = 0 then '0'
	else
	    round( (100*(sum(cast(abncalls as float)) / sum(cast((offered) as float)))), 1) 
end as perc_abn
from rt_split
where split in (select split from split_groups where param=@grp)






GO

