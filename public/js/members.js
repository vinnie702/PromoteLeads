var members = {}

members.profileInit = function ()
{

    $('#OwnerBio').click(function(e){
          e.preventDefault()
            $(this).tab('show')
    });

    $('#CompanyBio').click(function(e){
          e.preventDefault()
            $(this).tab('show')
    });

    $('#Videos').click(function(e){
          e.preventDefault()
            $(this).tab('show')
    });
}
