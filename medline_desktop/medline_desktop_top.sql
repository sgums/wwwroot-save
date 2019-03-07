USE [cms]
GO

/****** Object:  StoredProcedure [dbo].[medline_desktop_right]    Script Date: 1/11/2017 7:46:52 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO




CREATE procedure [dbo].[medline_desktop_right] (@grpName nchar(30))
as

--declare @grpName nchar(30);
--set @grpName = 'Self_Pay';


select
sum(acdcalls) as acdcalls,
sum(waiting) as waiting,
case 
	when sum(offered) = 0 then 0
	else
		round( (100*(sum(cast(acceptable as float)) / sum(cast((offered) as float)))), 1)
end as svclvl
from rt_split
where split in (select split from split_groups where group_name=@grpName);



GO

