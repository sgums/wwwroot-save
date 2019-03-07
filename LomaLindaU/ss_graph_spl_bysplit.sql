USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[ss_graph_stat_spl_bysplit]    Script Date: 1/30/2017 3:53:50 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO







CREATE procedure [dbo].[ss_graph_stat_spl_bysplit] (@spl int)
as

select
case 
	when sum(offered) = 0 then 0
	else
		round( (100*(sum(cast(acceptable as float)) / sum(cast((offered) as float)))), 1)
end as svclvl,
max(waiting) as waiting,
max(oldest) as oldest_seconds,
cast((cast(max(oldest) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(max(oldest) as int)%60) as varchar(2)),2) as oldest,
case
	when sum(acdcalls) = 0 then '0:00'
	else 
		cast((cast((sum(anstime)/sum(acdcalls)) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((sum(anstime)/sum(acdcalls)) as int)%60) as varchar(2)),2)
end as asa,
case
	when sum(acdcalls) = 0 then 0
	else
		cast( (cast(sum(anstime) as float) / cast(sum(acdcalls) as float)) as int)
end as asa_seconds,
sum(acdcalls) as acdcalls,
case
	when sum(acdcalls) = 0 then '0:00'
	else
		cast((cast((sum(acdtime)/sum(acdcalls)) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((sum(acdtime)/sum(acdcalls)) as int)%60) as varchar(2)),2)
end as att,
sum(abncalls) as abncalls,
case
	when sum(abncalls) = 0 then '0:00'
	else
	    cast((cast((sum(abntime)/sum(abncalls)) as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast((sum(abntime)/sum(abncalls)) as int)%60) as varchar(2)),2)
end as avgabntime,
sum(noansredir) as noansredir
from rt_split
where split=@spl;








GO

