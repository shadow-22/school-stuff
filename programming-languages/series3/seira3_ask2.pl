moredeli(File, Cost, Solution) :-
  read_input(File, Assoc_List, Rows, Lines, Assoc_Distance, Assoc_Prev),
  make_heap(Assoc_List, Initial_Heap, End_Index, Src_Index, Assoc_Distance, N_Distance), Initial_Min_Cost = 0,
  dijkstra(Assoc_List, Initial_Heap, Initial_Min_Cost, Cost, Solution, Src_Index, End_Index, Src_Index, 
           Rows, N_Distance, Assoc_Prev, Lines),!.

make_heap(Assoc_List, Initial_Heap, End_Index, Src_Index, Assoc_Distance, N_Distance) :-
  empty_heap(Empty),
  gen_assoc(Src_Index, Assoc_List, [83]),
  gen_assoc(End_Index, Assoc_List, [69]),
  add_to_heap(Empty, 0, Src_Index, Initial_Heap),
  put_assoc(Src_Index, Assoc_Distance, 0, N_Distance).

/*    
    length(Solution, Length),
    write(Length), nl,
    print_solution(Solution, 0, Length).
*/    

build_solution(Solution, Temp, Src_Index, Index, Rows, Assoc_Prev) :-
 get_assoc(Index, Assoc_Prev, Move),
(
  Index \= Src_Index
  ->  (   
         Move = r
         -> New_Index is Index - 1,
            build_solution(Solution, [r|Temp], Src_Index, New_Index, Rows, Assoc_Prev), !
      ;  Move = l 
         -> New_Index is Index + 1,
            build_solution(Solution, [l|Temp], Src_Index, New_Index, Rows, Assoc_Prev), !
      ;  Move = u
         -> New_Index is Index + Rows,
            build_solution(Solution, [u|Temp], Src_Index, New_Index, Rows, Assoc_Prev), !
      ;  Move = d
         -> New_Index is Index - Rows,
            build_solution(Solution, [d|Temp], Src_Index, New_Index, Rows, Assoc_Prev), !              
      )
  ;  Solution = Temp, !
).

print_solution(Solution, Index, Length) :-
  Index =< Length,
  Solution = [H|T],
  write(H), nl,
  New_Index is Index + 1,
  print_solution(T, New_Index, Length), !.

dijkstra(_, _, Min_Cost, Cost, Solution, Src_Index, End_Index, End_Index, Rows, _, Assoc_Prev, _) :- 
    Cost = Min_Cost,
    build_solution(Solution, [], Src_Index, End_Index, Rows, Assoc_Prev).

dijkstra(Assoc_List, Heap, _, Cost, Solution, Src_Index, End_Index, _, Rows, 
         Assoc_Distance, Assoc_Prev, Lines) :-
    get_from_heap(Heap, New_Min_Cost, New_Min_Index, Fix_Heap),
    update_neighbours(New_Min_Index, New_Min_Cost, 0, Rows, Assoc_List, Assoc_Distance, Fix_Heap, New_Heap,
                    Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance),  
    dijkstra(Assoc_List, New_Heap, New_Min_Cost, Cost, Solution, Src_Index, End_Index, New_Min_Index, Rows, 
           New_Assoc_Distance, New_Assoc_Prev, Lines), !.   

update_neighbours(Min_Index, Min_Cost, 0, Rows, Assoc_List, Assoc_Distance, 
                  Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance) :-
  Min_J is Min_Index mod Rows,
(	
  New_Counter is 0 + 1, 
  right(Min_Index, Min_J, Min_Cost, Rows, Assoc_List, Result_R, Assoc_Distance, Right_Cost, Index_Right),
  Result_R = true
  ->  update_right(Heap, Index_Right, Assoc_Distance, Right_Cost, Assoc_Prev, 
                   Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap),
  	  update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, Updated_Assoc_Distance,
  	                    Updated_Heap, New_Heap, Lines, Updated_Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance), !
   ;  New_Counter is 1,
      update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, 
                        Assoc_Distance, Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance), !             
).

update_neighbours(Min_Index, Min_Cost, 1, Rows, Assoc_List, Assoc_Distance, 
                  Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance) :-
  Min_J is Min_Index mod Rows,
(
  New_Counter is 1 + 1, 
  left(Min_Index, Min_J, Min_Cost, Rows, Assoc_List, Result_L, Assoc_Distance, Left_Cost, Index_Left),
  Result_L = true
  -> update_left(Heap, Index_Left, Assoc_Distance, Left_Cost, Assoc_Prev, 
                 Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap),
  	 update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, Updated_Assoc_Distance,
  	                   Updated_Heap, New_Heap, Lines, Updated_Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance), !
  ;  New_Counter = 2,
     update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, 
                       Assoc_Distance, Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance), !
).

update_neighbours(Min_Index, Min_Cost, 2, Rows, Assoc_List, Assoc_Distance, 
                  Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance) :-
  Min_I is Min_Index / Rows,
(
   New_Counter is 2 + 1,
   up(Min_Index, Min_I, Min_Cost, Rows, Assoc_List, Result_U, Assoc_Distance, Up_Cost, Index_Up),
   Result_U = true
   -> update_up(Heap, Index_Up, Assoc_Distance, Up_Cost, Assoc_Prev,
                Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap),
  	  update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, Updated_Assoc_Distance,
  	                    Updated_Heap, New_Heap, Lines, Updated_Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance), !
   ;  New_Counter = 3,
      update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, Assoc_Distance,
                        Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance), !  	  
).

update_neighbours(Min_Index, Min_Cost, 3, Rows, Assoc_List, Assoc_Distance, 
                  Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance) :-
  Min_I is Min_Index / Rows,
(
    New_Counter is 3 + 1,  
    down(Min_Index, Min_I, Min_Cost, Rows, Lines, Assoc_List, Result_D, Assoc_Distance, Down_Cost, Index_Down),
  	Result_D = true
  	-> update_down(Heap, Index_Down, Assoc_Distance, Down_Cost, Assoc_Prev,
                   Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap),
  	   update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, 
  	   	                 Updated_Assoc_Distance, Updated_Heap, New_Heap, Lines, Updated_Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance),!	
  	; New_Counter is 4, 
      update_neighbours(Min_Index, Min_Cost, New_Counter, Rows, Assoc_List, Assoc_Distance, 
  		                  Heap, New_Heap, Lines, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance), !
).

update_neighbours(_, _, 4, _, _, Assoc_Distance, 
                  Heap, New_Heap, _, Assoc_Prev, New_Assoc_Prev, New_Assoc_Distance) :-
       New_Assoc_Distance = Assoc_Distance,
       New_Assoc_Prev = Assoc_Prev,
       New_Heap = Heap.

right(Min_Index, Min_J, Min_Cost, _, Assoc_List, Result_R, Assoc_Distance, Right_Cost, Index_Right) :-
  ( 
  	Min_J \= 0,
    Index_Right is Min_Index - 1,
    get_assoc(Min_Index, Assoc_List, Z),
    Z \= [88],
    get_assoc(Index_Right, Assoc_List, W),
    W \= [88],
    get_assoc(Index_Right, Assoc_Distance, Current_Distance),
    Min_Cost + 2 < Current_Distance
    -> Result_R = true,
       Right_Cost is Min_Cost + 2
    ;  Result_R = false               
  ). 

left(Min_Index, Min_J, Min_Cost, Rows, Assoc_List, Result_L, Assoc_Distance, Left_Cost, Index_Left) :- 
  (
  	Min_J =< Rows - 2,
    Index_Left is Min_Index + 1,
    get_assoc(Min_Index, Assoc_List, Z),
    Z \= [88],
    get_assoc(Index_Left, Assoc_List, W),
    W \= [88],
    get_assoc(Index_Left, Assoc_Distance, Current_Distance),
    Min_Cost + 1 < Current_Distance
    ->  Result_L = true,
        Left_Cost is Min_Cost + 1
    ;   Result_L = false   
  ).

up(Min_Index, Min_I, Min_Cost, Rows, Assoc_List, Result_U, Assoc_Distance, Up_Cost, Index_Up) :-
  (
  	Min_I \= 0,
    Index_Up is Min_Index - Rows,
    get_assoc(Min_Index, Assoc_List, Z),
    Z \= [88],
    get_assoc(Index_Up, Assoc_List, W),
    W \= [88],
    get_assoc(Index_Up, Assoc_Distance, Current_Distance),
    Min_Cost + 3 < Current_Distance
    -> Result_U = true,
       Up_Cost is Min_Cost + 3
    ;  Result_U = false
  ).

down(Min_Index, Min_I, Min_Cost, Rows, Lines, Assoc_List, Result_D, Assoc_Distance, Down_Cost, Index_Down) :- 
  (
  	Min_I =< Lines - 1,
    Index_Down is Min_Index + Rows,
    get_assoc(Min_Index, Assoc_List, Z),
    Z \= [88],
    get_assoc(Index_Down, Assoc_List, W),
    W \= [88],
    get_assoc(Index_Down, Assoc_Distance, Current_Distance),
    Min_Cost + 1 < Current_Distance
    -> Result_D = true,
       Down_Cost is Min_Cost + 1
    ;  Result_D = false
  ).    

update_right(Heap, Index_Right, Assoc_Distance, Right_Cost, Assoc_Prev, Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap) :-
  put_assoc(Index_Right, Assoc_Distance, Right_Cost, Updated_Assoc_Distance),
  put_assoc(Index_Right, Assoc_Prev, l, Updated_Assoc_Prev),
  add_to_heap(Heap, Right_Cost, Index_Right, Updated_Heap).

update_left(Heap, Index_Left, Assoc_Distance, Left_Cost, Assoc_Prev, Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap) :-
  put_assoc(Index_Left, Assoc_Distance, Left_Cost, Updated_Assoc_Distance),
  put_assoc(Index_Left, Assoc_Prev, r, Updated_Assoc_Prev),
  add_to_heap(Heap, Left_Cost, Index_Left, Updated_Heap).

update_up(Heap, Index_Up, Assoc_Distance, Up_Cost, Assoc_Prev, Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap) :-
  put_assoc(Index_Up, Assoc_Distance, Up_Cost, Updated_Assoc_Distance),
  put_assoc(Index_Up, Assoc_Prev, u, Updated_Assoc_Prev),
  add_to_heap(Heap, Up_Cost, Index_Up, Updated_Heap).

update_down(Heap, Index_Down, Assoc_Distance, Down_Cost, Assoc_Prev, Updated_Assoc_Distance, Updated_Assoc_Prev, Updated_Heap) :-
  put_assoc(Index_Down, Assoc_Distance, Down_Cost, Updated_Assoc_Distance),
  put_assoc(Index_Down, Assoc_Prev, d, Updated_Assoc_Prev),
  add_to_heap(Heap, Down_Cost, Index_Down, Updated_Heap).

read_input(File, Assoc_List, Rows, Lines, Assoc_Distance, Assoc_Prev) :-
  empty_assoc(Temp1),
  empty_assoc(Temp_Distance),
  empty_assoc(Temp_Prev),
  open(File, read, Stream),
  Index is -1,
  T_Lines is 1,
  read_file(Stream, Index, Temp1, Assoc_List, T_Lines, Rows, Lines, 
            Temp_Distance, Assoc_Distance, Temp_Prev, Assoc_Prev).

read_file(Stream, Index, Temp1, Assoc_List, T_Lines, Rows, Lines,
          Temp_Distance, Assoc_Distance, Temp_Prev, Assoc_Prev) :-
    get_char(Stream, Char),
  (
    Char \= end_of_file
    -> ( Char \= '\n'
    	 -> NI is Index + 1,
    	    atom_codes(Char, Code),
    	    put_assoc(NI, Temp1, Code, Temp2),
    	    put_assoc(NI, Temp_Distance, 10000000000000, Temp_D2),
    	    put_assoc(NI, Temp_Prev, 'X', Temp_P2),
    	    read_file(Stream, NI, Temp2, Assoc_List, T_Lines, Rows, Lines, 
                    Temp_D2, Assoc_Distance, Temp_P2, Assoc_Prev), !
    	 ;  N_Lines is T_Lines + 1,
    	    read_file(Stream, Index, Temp1, Assoc_List, N_Lines, Rows, Lines,
    	              Temp_Distance, Assoc_Distance, Temp_Prev, Assoc_Prev), !
       )
    ;    Assoc_List = Temp1,
         Assoc_Distance = Temp_Distance,
         Assoc_Prev = Temp_Prev,
         Lines is T_Lines - 1,
         Rows is (Index + 1) / Lines
  ).  
        