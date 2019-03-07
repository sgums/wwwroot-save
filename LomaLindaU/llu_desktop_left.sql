USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[llu_desktop_left]    Script Date: 1/30/2017 3:50:54 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO






CREATE procedure [dbo].[llu_desktop_left] (@grpName varchar(20))
as

--declare @grpName varchar(20);
--set @grpName = 'operations';


select
sum(acdcalls) as acdcalls,
sum(waiting) as waiting,
case 
	when sum(offered) = 0 then 0
	else
		round( (100*(sum(cast(acceptable as float)) / sum(cast((offered) as float)))), 1)
end as svclvl
from rt_split
where split in (select split from split_groups where param=@grpName);





GO

