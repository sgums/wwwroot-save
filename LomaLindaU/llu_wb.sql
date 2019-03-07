USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[llu_wb]    Script Date: 1/30/2017 3:51:19 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO







CREATE procedure [dbo].[llu_wb] (@grpName nchar(30))
as

--declare @grpName nchar(30);
--set @grpName = 'operations';


select top 7
split,
splitname,
staffed,
available,
other,
waiting,
oldest as oldest_sec,
case 
	when offered = 0 then 0
	else
		round( (100*(cast(acceptable as float) / cast((offered) as float))), 1)
end as svclvl,
cast((cast(oldest as int) /60) as varchar(10)) + ':' + right('00' + cast ((cast(oldest as int)%60) as varchar(2)),2) as oldest
from rt_split
where split in (select split from split_groups where param=@grpName) and waiting > 0
order by waiting desc, oldest desc, svclvl






GO

