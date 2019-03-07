USE [Voast]
GO

/****** Object:  StoredProcedure [dbo].[currentValue]    Script Date: 1/30/2017 3:50:08 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO






CREATE procedure [dbo].[currentValue] (@grp varchar(20))
as

--declare @grp varchar(20);
--set @grp = 'operations';


declare @cdate varchar(15);
set @cdate = convert (varchar(15),getdate(),1);

select
sum(rt_offered) as offered
from rt_split
where split in (select split from split_groups where param=@grp)



GO

