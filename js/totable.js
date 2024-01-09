function addToTable(data){

    //alert(data.job_description + " " + data.job_date);
    // $("#jobTable").find('tbody')
    // .append($('<tr>')
    //     .append($('<td>')
    //         .append($('<img>')
    //             .attr('src', 'img.png')
    //             .text('Image cell')
    //         )
    //     )
    // );

    // $("#jobTable").find('tbody')
    //     .append($('<tr>')
    //     .append($('<td>kalle anka</td>'))
    //     .append($('<td>kalle anka</td>'))
    //     .append($('<td>kalle anka</td>'))
    //     .append($('</tr>'))
    // );

    let dataRow = "<tr>";
    dataRow = dataRow + "<td>ETT</td>";
    dataRow = dataRow + "<td>TVÅ</td>";
    dataRow = dataRow + "<td>TRE</td>";
    dataRow = dataRow + "</tr>";

    $("#jobTable tbody").append(dataRow);
        
    
}