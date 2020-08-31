global.buildKeyValueTable = (myObject, selector) => {
    // console.log(myObject);
    let header = '<tr><th>Col1</th><th>Col2</th></tr>';
    $(selector).append(header);
    for (let i in myObject) {
        // console.log(i);
        let row = $('<tr/>');
        row.append('<td>' + i + '</td><td>' + myObject[i] + '</td>');
        // for (let colIndex = 0; colIndex < 2; colIndex++) {
        //     let cellValue = myObject[i][colIndex];
        //     if (cellValue == null)
        //         cellValue = "";
        //     row.append($('<td/>').html(cellValue));
        // }
        $(selector).append(row);
    }
}

global.buildHtmlTable = function buildHtmlTable(myList, selector) {
    const columns = addAllColumnHeaders(myList, selector);

    for (let i = 0; i < myList.length; i++) {
        let row$ = $('<tr/>');
        for (let colIndex = 0; colIndex < columns.length; colIndex++) {
            let cellValue = myList[i][columns[colIndex]];
            if (cellValue == null)
                cellValue = "";
            row$.append($('<td/>').html(cellValue));
        }
        $(selector).append(row$);
    }
}

// Adds a header row to the table and returns the set of columns.
// Need to do union of keys from all records as some records may not contain
// all records.
function addAllColumnHeaders(myList, selector) {
    let columnSet = [];
    let headerTr$ = $('<tr/>');

    for (let i = 0; i < myList.length; i++) {
        let rowHash = myList[i];
        for (let key in rowHash) {
            if ($.inArray(key, columnSet) !== -1) {
                columnSet.push(key);
                headerTr$.append($('<th/>').html(key));
            }
        }
    }
    $(selector).append(headerTr$);

    return columnSet;
}