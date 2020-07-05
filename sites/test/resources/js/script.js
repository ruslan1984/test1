$( document ).ready( function () {
    var auth = Boolean($('.header').attr('auth'));
    var data = {
        width: "100%",
        inserting: false,
        filtering: false,
        editing: auth,
        sorting: true,
        paging: false,
        autoload: true,
        sortOrder: 'desc',
        sortName: 'created_at',
        sort: function(ind) {
            sorting( ind);
        },
        controller: {
            loadData: () => {
                var d = $.Deferred();
                var params = getUrlParams( window.location.href );
                var page = 1;
                if ( $.isNumeric( params.page ) ) {
                    page = params.page;
                }
                $.ajax( {
                    url: "/data/?page=" + page +
                        "&sort_order=" + data.sortOrder +
                        "&sort_name=" + data.sortName,
                    dataType: "json"
                } ).done( function ( response ) {
                    d.resolve( response.data );
                } );
                return d.promise();
            },
            updateItem: async function ( item ) {
                let response = await fetch( "/update/", {
                    method: 'POST',
                    body: JSON.stringify( item ),
                } );

                if ( response.status == 200 ) {
                    let result = await response.text();
                    switch ( result ) {
                        case '-1':
                            alert( "Ошибка авторизации" );
                            break;
                        case '-2':
                            alert( "Ошибка валидации" );
                            break;
                        case '1':
                            alert( "Данные успешно обновлены!" );
                            grid.jsGrid( "loadData" );
                            break;
                        default:
                            alert( "Ошибка" );
                            break
                    }
                }
            },
        },
        fields: [ {
            name: "user",
            title: "Имя пользователя",
            type: "text",
            width: 150,
            validate: "required",
            sort: "ASC",
            editing: false,
            sorting: true,
        },
        {
            name: "email",
            type: "number",
            width: 50,
            editing: false
        },
        {
            name: "task",
            title: "Текст задачи",
            type: "text",
            width: 200
        },
        {
            name: "status",
            title: "Cтатус",
            type: "text",
            width: 200,
            editing: false,
            sorter: () => {
                sorting( 3 );
            }
        },
        { 
            name: "taskReady", 
            type: "checkbox", 
            title: "Задание выполнено"
        },
        {
            type: "control",
            deleteButton: false
        }
        ]
    }
    var grid = $( "#jsGrid" ).jsGrid( data );

    function getUrlParams( url ) {
        if ( typeof url == 'undefined' ) {
            url = window.location.search
        }
        var url = url.split( '#' )[ 0 ]
        var urlParams = {}
        var queryString = url.split( '?' )[ 1 ]
        if ( !queryString ) {
            if ( url.search( '=' ) !== false ) {
                queryString = url
            }
        }
        if ( queryString ) {
            var keyValuePairs = queryString.split( '&' )
            for ( var i = 0; i < keyValuePairs.length; i++ ) {
                var keyValuePair = keyValuePairs[ i ].split( '=' )
                var paramName = keyValuePair[ 0 ]
                var paramValue = keyValuePair[ 1 ] || ''
                urlParams[ paramName ] = decodeURIComponent( paramValue.replace( /\+/g, ' ' ) )
            }
        }
        return urlParams
    }
    function sorting( index ) {
        data.fields[ index ].sort = getSort( data.fields[ index ].sort );
        data.sortOrder = data.fields[ index ].sort;
        data.sortName = data.fields[ index ].name;
        grid.jsGrid( "loadData" );
    }
    function getSort( sort ) {
        return ( sort === "asc" ) ? "desc" : "asc";
    }
} );