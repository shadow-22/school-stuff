fun skitrip(filename:string):int = 
    let 
(*Utility functions.*)        
        fun parse file =
           let
              fun next_int input = Option.valOf (TextIO.scanStream (Int.scan StringCvt.DEC) input);
              val stream = TextIO.openIn file;
              val n = next_int stream;
              val _ = TextIO.inputLine stream;
              fun scanner 0 acc = acc
                | scanner i acc =
               let
                  val d = next_int stream
               in
                  scanner (i - 1) (d :: acc)
               end;
           in
                (n, rev(scanner n []))   
           end

        fun make_left (name:int array, i:int, lim:int, min:int, left:int list) = 
         if i > lim-1 then Array.fromList(rev(left))
         else if (Array.sub(name, i) < min) then 
                  (
                     make_left(name, i+1, lim, Array.sub(name, i), i::left)
                  )
        else      (
                     make_left(name, i+1, lim, min, left)
                  )

        fun make_right (name:int array, i:int, lim:int, max:int, right:int list) = 
         if i < lim-1 then Array.fromList(rev(right))
         else if (Array.sub(name, i) > max) then
                 (
                     make_right(name, i-1, lim, Array.sub(name, i), i::right)
                 )
        else
                 (
                     make_right(name, i-1, lim, max, right)
                 )

        val myArray = Array.fromList(#2 (parse filename))

        fun main(x) = Array.sub(myArray, x)

        fun size(name) = Array.length(name)

        val left = make_left(myArray, 1, size(myArray), main(0), 0::nil)

        val right = make_right(myArray, size(myArray)-1, 1, main(size(myArray)-1), size(myArray)-1::nil)

        val j = size(right)-1

        fun str(integer) = Int.toString(integer)

        fun R(x) = Array.sub(right,x)

        fun L(x) = Array.sub(left,x)
(*START of Algorithm.*)
        fun inside_loop(i, j, max) = 
            if (j < 0 orelse main(R(j)) < main(L(i))) then (max, j)
            else (
                   if ( (R(j)-L(i)) > max)
                     then (
(*                          print ("max="^str(R(j)-L(i))^"----"^str(main(R(j)))^"->"^str(main(L(i)))^"\n");         *)   
                            inside_loop(i, j-1, R(j)-L(i))
                          )
                   else inside_loop(i, j-1, max)     
                 )

        fun outside_loop(i, max, j) = 
            if (i > (size(left)-1) orelse j < 0) then max        
            else ( 
                   let
                    val max_tmp = #1 (inside_loop(i, j, max));
                    val j_tmp = #2 (inside_loop(i, j, max));
                  in
                    outside_loop(i+1, max_tmp, j_tmp)
                  end
           (*       outside_loop(i+1, #1 inside_loop(i,j,max), #2 inside_loop(i,j,max))  *)
                 )
(*END of Algorithm.*)               
 (*       val answer = outside_loop(0, 0) *) 
    in
 (*       print (str(answer)^"\n")  *)
    outside_loop(0, 0, j)
    end                