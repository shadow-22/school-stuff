fun find(x, parent, update_parent:int*int->unit) = 
    if (parent(x) <> x) 
      then (
      	    update_parent(x, find(parent(x), parent, update_parent));
      	    parent(x)
      	   )	
  else parent(x);

fun union(x, y, counter, parent, update_parent:int*int->unit, rank, update_rank:int*int->unit) = 
    let 
        val xRoot = find(x, parent, update_parent);
        val yRoot = find(y, parent, update_parent)
    in
        if (xRoot = yRoot) then counter
        else (
                if (rank(xRoot) < rank(yRoot))
                	then (
                		    update_parent(xRoot, yRoot);
                	  	    counter - 1
                	  	 )
                else if (rank(yRoot) < rank(xRoot))
                	then (
                		    update_parent(yRoot, xRoot);
                		    counter - 1
                		 )
                else (
                        update_parent(yRoot, xRoot);
                        update_rank(xRoot, rank(xRoot)+1);
                        counter - 1
                	 )
             )
    end

fun outer_loop(n, m, k, counter, next_int, stream, parent, update_parent, rank, update_rank) = 
    if (m = 0) then counter
    else (
           let 
           	   val src = next_int stream;
           	   val dest = next_int stream;
           	   val new_count = union(src, dest, counter, parent, update_parent, rank, update_rank)
           in
           	   outer_loop(n, m - 1, k, new_count, next_int, stream, parent, update_parent, rank, update_rank)
           end
         ); 

fun fill_parent_array(Parent, i, n, update_parent) = 
    if (i = n) then ()
    else (
           update_parent(i, i);
           fill_parent_array(Parent, i+1, n, update_parent)
         );

fun print_parent(Parent, i, n) = 
    if (i = n) then ()
    else (
           print(Int.toString(Array.sub(Parent, i)) ^ "\n");
           print_parent(Parent, i+1, n)
         );

fun parse file = 
    let 
        fun next_int input = Option.valOf(TextIO.scanStream (Int.scan StringCvt.DEC) input);
        val stream = TextIO.openIn file;
        val n = next_int stream; 
        val m = next_int stream; 
        val k = next_int stream; 
        val counter = n 
        val Parent:int array = Array.array(n+1, 0);
        fun parent(i) = Array.sub(Parent, i);
        fun update_parent(i, value) = Array.update(Parent, i, value);
        val () = fill_parent_array(Parent, 1, n+1, update_parent); 
        val Rank:int array = Array.array(n+1, 0);
        fun rank(i) = Array.sub(Rank, i);
        fun update_rank(i, value) = Array.update(Rank, i, value);			
    (*	val () = print_parent(Parent, 1, n+1);	*)
        val count:int = outer_loop(n, m, k, counter, next_int, stream, parent, update_parent, rank, update_rank) 
    in                                           
       if (count = 1) then (*print("1\n")*) 1
       else if (count - k <= 1) then (*print("1\n")*) 1
       else (*print(Int.toString(count - k) ^ "\n")*) count-k
    end;	

fun villages input_file = parse input_file;