(*Klemmenh domh dedomenwn gia to binary heap tou dijkstra*)
(*http://www.cs.cornell.edu/courses/cs312/2006fa/recitations/rec14.html*)

fun compare (x:int*int, y:int*int) = 
  if (#2 x > #2 y) then GREATER
  else LESS

signature IMP_PRIOQ =
  sig
    type 'a prioq
    val create : ('a * 'a -> order) -> 'a prioq
    val insert : 'a prioq -> 'a -> unit
    val extract_min : 'a prioq -> 'a 
    val empty : 'a prioq -> bool
  end

structure Heap : IMP_PRIOQ =
  struct
    type 'a heap = {compare : 'a*'a->order,
                    next_avail: int ref,
                    values : 'a option Array.array
                    }
    type 'a prioq = 'a heap

fun get_elt(values:'a option Array.array, p:int):'a =
  valOf(Array.sub(values,p))

val max_size = 500000
fun create(cmp: 'a*'a -> order):'a heap =
  {compare = cmp,
   next_avail = ref 0,
   values = Array.array(max_size,NONE)}
fun empty({compare,next_avail,values}:'a heap) = (!next_avail) = 0

exception FullHeap
exception InternalError
exception EmptyQueue

fun parent(n) = (n-1) div 2
fun left_child(n) = 2*n + 1
fun right_child(n) = 2*n + 2

fun insert({compare,next_avail,values}:'a heap) (me:'a): unit =
  if (!next_avail) >= Array.length(values) then
    raise FullHeap
  else
    let fun bubble_up(my_pos:int):unit =
      if my_pos = 0 then ()
      else
        let 
          val parent_pos = parent(my_pos);
          val parent = get_elt(values, parent_pos)
        in
          case compare(parent, me) of
            GREATER =>
              (Array.update(values,my_pos,SOME parent);
               Array.update(values,parent_pos,SOME me);
               bubble_up(parent_pos))
          | _ => () 
        end
        val my_pos = !next_avail
    in
      next_avail := my_pos + 1;
      Array.update(values,my_pos,SOME me);
      bubble_up(my_pos)
    end

exception EmptyQueue

fun extract_min({compare,next_avail,values}:'a heap):'a =
  if (!next_avail) = 0 then raise EmptyQueue
  else 
    let val result = get_elt(values,0)
      val last_index = (!next_avail) - 1
      val last_elt = get_elt(values, last_index)
      fun min_child(my_pos): int*'a =
        let
          val left_pos = left_child(my_pos)
          val right_pos = right_child(my_pos)
          val left_val = get_elt(values, left_pos)
        in
          if right_pos >= last_index then (left_pos, left_val)
          else
            let val right_val = get_elt(values, right_pos) in
              case compare(left_val, right_val)
                of GREATER => (right_pos, right_val)
                 | _ => (left_pos, left_val)
            end
        end
      fun bubble_down(my_pos:int, my_val: 'a):unit =
        if left_child(my_pos) >= last_index then () 
        else let val (swap_pos, swap_val) = min_child(my_pos) in
          case compare(my_val, swap_val)
            of GREATER =>
              (Array.update(values,my_pos,SOME swap_val);
               Array.update(values,swap_pos,SOME my_val);
               bubble_down(swap_pos, my_val))
             | _ => () 
        end
    in
      Array.update(values,0,SOME last_elt);
      Array.update(values,last_index,NONE);
      next_avail := last_index;
      bubble_down(0, last_elt);
      result
    end
  end

fun parse file =
        let
            fun next_String input = (TextIO.inputAll input) 
            val stream = TextIO.openIn file
            val a = next_String stream
            val lista = explode(a)
        in
            lista
        end

val grid_array = Array2.array(1000, 1000, #"X")

fun fill_array(lista:char list, i:int, j:int, x:int, y:int, source:int*int, end_p:int*int) = 
  if (lista <> nil)
     then (
            if (hd lista = #"\n")
               then (
                         fill_array(tl lista, i+1, 0, x+1, y, source, end_p)
                    )
            else (
                if (hd lista = #"S")
                   then(
                         Array2.update(grid_array, i, j, hd(lista));
                         fill_array(tl lista, i, j+1, x, y+1, (i,j), end_p)
                   )
                else if (hd lista = #"E")
                   then(
                         Array2.update(grid_array, i, j, hd(lista));
                         fill_array(tl lista, i, j+1, x, y+1, source, (i,j))
                   )
                else( 
                         Array2.update(grid_array, i, j, hd(lista));
                         fill_array(tl lista, i, j+1, x, y+1, source, end_p)
                )     
                   )  
          )
  else 
    (x-1,y div (x-1), source, end_p);          

fun grid(i,j) = Array2.sub(grid_array,i,j);

fun print_grid(myArray:char Array2.array,i,j,x,y) = 
  if (i >= x)
     then ()
  else (
      if (j < y)
        then (
               print(Char.toString(grid(i,j)));
               print_grid(myArray,i,j+1,x,y)
             )
      else (
             print("\n");
             print_grid(myArray,i+1,0,x,y)
           )
    );  

fun print_path(prev, i, src_index, y, count, path_list:char list) = 
    if (i = src_index) then String.implode(path_list)
    else if (prev(i) = #"U") then (print_path(prev, i+y, src_index, y, count+1, prev(i)::path_list) (* print(Char.toString(prev(i))) *) )
    else if (prev(i) = #"D") then (print_path(prev, i-y, src_index, y, count+1, prev(i)::path_list) (* print(Char.toString(prev(i))) *) )
    else if (prev(i) = #"L") then (print_path(prev, i+1, src_index, y, count+1, prev(i)::path_list) (* print(Char.toString(prev(i))) *) )
    else (* if (prev(i) = #"R") then *) (print_path(prev, i-1, src_index, y, count+1, prev(i)::path_list) (* print(Char.toString(prev(i))) *) ); 
 (*   else print "Error.\n"; *)

fun dijkstra(heap, min:int*int, end_index, x, y, dist, prev, update_dist, update_prev, dest, removed, src_index, Removed, update_rem, Dist, Prev) = 
  let 
      val min_i = (#1 min) div(y);
      val min_j = (#1 min) mod(y);
      val min_index = min_i * y + min_j;
      val min_distance = #2 min;
      val left = (min_j <= y-2 andalso removed(min_index) <> true andalso removed(min_index+1) <> true andalso grid(min_i,min_j) <> #"X" andalso grid(min_i,min_j+1) <> #"X" andalso min_distance+1 < dist(min_index+1));
      val right = (min_j <> 0 andalso removed(min_index) <> true andalso removed(min_index-1) <> true andalso grid(min_i,min_j) <> #"X" andalso grid(min_i,min_j-1) <> #"X" andalso min_distance+2 < dist(min_index-1));
      val down = (min_i <= x-2 andalso removed(min_index) <> true andalso removed(min_index+y) <> true andalso grid(min_i,min_j) <> #"X" andalso grid(min_i+1,min_j) <> #"X" andalso min_distance+1 < dist(min_index+y));
      val up = (min_i <> 0 andalso removed(min_index) <> true andalso removed(min_index-y) <> true andalso grid(min_i,min_j) <> #"X" andalso grid(min_i-1,min_j) <> #"X" andalso min_distance+3 < dist(min_index-y))

      fun update_left() =  ( update_dist(min_index+1, min_distance+1);
                             update_prev(min_index+1, #"R");
                             Heap.insert heap(min_index+1, min_distance+1))
                        (*   print ("Distance " ^ Int.toString(min_index+1) ^ " = " ^ Int.toString(min_distance+1) ^ " Previous = " ^ Char.toString(prev(min_index+1)) ^ "\n")) *)

      fun update_right() = ( update_dist(min_index-1, min_distance+2);
                             update_prev(min_index-1, #"L");
                             Heap.insert heap(min_index-1, min_distance+2))
                        (*   print ("Distance " ^ Int.toString(min_index-1) ^ " = " ^ Int.toString(min_distance+2) ^ " Previous = " ^ Char.toString(prev(min_index-1)) ^ "\n")) *)

      fun update_down() =  (
                             update_dist(min_index+y, min_distance+1);
                             update_prev(min_index+y, #"D");
                             Heap.insert heap(min_index+y, min_distance+1))
                        (*   print ("Distance " ^ Int.toString(min_index+y) ^ " = " ^ Int.toString(min_distance+1) ^ " Previous = " ^ Char.toString(prev(min_index+y)) ^ "\n")) *)
          
      fun update_up() =    (
                             update_dist(min_index-y, min_distance+3);
                             update_prev(min_index-y, #"U");
                             Heap.insert heap(min_index-y, min_distance+3))
                        (*   print ("Distance " ^ Int.toString(min_index-y) ^ " = " ^ Int.toString(min_distance+3) ^ " Previous = " ^ Char.toString(prev(min_index-y)) ^ "\n")) *)
                  
     fun rec_dijkstra() = dijkstra(heap, Heap.extract_min heap, end_index, x, y, dist, prev, update_dist, update_prev, dest, removed, src_index, Removed,update_rem, Dist, Prev);  

     fun update_neightbours(count:int) = if (count <= 4) then (
                                                                 if (count = 1 andalso right = true) then 
                                                                    (update_right(); update_neightbours(count+1))
                                                                 else if (count = 2 andalso left = true) then 
                                                                    (update_left(); update_neightbours(count+1))
                                                                 else if (count = 3 andalso down = true) then 
                                                                    (update_down(); update_neightbours(count+1))
                                                                 else if (count = 4 andalso up = true) then 
                                                                    (update_up(); update_neightbours(count+1))
                                                                 else update_neightbours(count+1)
                                                              )
                                           else ()      
  in
    if (min_index = end_index) then 
         (
          (*
           print (Int.toString(dist(end_index)) ^ " ");
           print_path(prev, end_index, src_index, y, 0);
           print "\n"
           *)
           (dist(end_index), print_path(prev, end_index, src_index, y, 0, nil))
         )
    else (
           if (removed(min_index) = true) then rec_dijkstra()
           else (
                  update_rem(min_index, true); 
                  update_neightbours(1);
              (*  update_rem(min_index, true); *)
                  rec_dijkstra()
                )
         )
  end                

fun moredeli(filename:string) = 
                                    let 
                                      val myList = parse filename;
                                      val size_ofList = List.length(myList);
                                      val grid_properties = fill_array(myList,0,0,1,0,(0,0),(0,0));
                                      val x = #1 grid_properties;
                                      val y = #2 grid_properties;
                                      val src = #3 grid_properties;
                                      val dest = #4 grid_properties; 
                                      val Prev:char array = Array.array(x*y, #"N");
                                      val Dist = Array.array(x*y, valOf(Int.maxInt));
                                      fun dist(i) = Array.sub(Dist,i);  
                                      fun prev(i) = Array.sub(Prev,i);
                                      fun update_dist(i,value) = Array.update(Dist,i,value);
                                      fun update_prev(i,value) = Array.update(Prev,i,value);
                                      val src_index = (#1 src) * y + (#2 src);
                                      val end_index = (#1 dest) * y + (#2 dest);
                                      val Removed = Array.array(x*y, false);
                                      fun removed(i) = Array.sub(Removed,i)
                                      fun update_rem(i,x) = Array.update(Removed,i,x);  
                                      val heap = Heap.create compare;
                                      val () = Heap.insert heap(src_index, 0);
                                      val () = update_dist(src_index, 0) 
                                    in 
                                      (*
                                      print "\n**************************************************************************";
                                      print("\nDist array has " ^ Int.toString(x*y) ^ " cells\n");
                                      print ("\nDestination distance: " ^ Int.toString(dist(end_index)) ^ "\n");
                                      print("\nThe grid has " ^ Int.toString(x) ^ " rows and " ^ Int.toString(y) ^ " columns");
                                      print("\n\nThe grid is: \n");
                                      print_grid(grid_array, 0, 0, x, y);
                                      print("\nSource coordinates: ("^Int.toString(#1 src)^", "^Int.toString(#2 src)^").\n");
                                      print("Destination coordinates: ("^Int.toString(#1 dest)^", "^Int.toString(#2 dest)^").\n\n");
                                      print("Source index: " ^ Int.toString(src_index) ^ "\n");
                                      print("Destination index: " ^ Int.toString(end_index) ^ "\n\n");
                                      *)
                                     dijkstra(heap, Heap.extract_min heap,end_index,x,y,dist,prev,update_dist,update_prev,dest,removed,src_index,Removed,update_rem, Dist, Prev)                                      
                                    end;

(* moredeli "grid.txt";   *)  