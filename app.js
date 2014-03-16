    
    
	// Create the database by instantiating a new TAFFY object.
    var cities = TAFFY();
    
    //Populate the database with records
    cities.insert( {name:"New York", state:"NY"} );
    cities.insert( {name:"Portland", state:"OR"} );

    // The Schema for DB records does NOT need to match.
    // IE. The records can contain different columns.
    // Example:
    cities.insert( {name:"Boston", state:"MA", population:543} );
    
    cities.insert( {name:"Detroit", state:"MI"} );
    cities.insert( {name:"Memphis", state:"TN"} );
    cities.insert( {name:"New Haven", state:"CT"} );

    // Retrieve a record from the DB
    test = cities({name:"Boston"});
    test = test.first();

    // Output the chosen records population
    alert(test.population);