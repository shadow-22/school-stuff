skitrip(File, Answer) :-
  make_lists(File, Answer).
%  write(Answer), nl.

make_lists(File, Max_Distance) :-
  read_input(File, Input_List),
  reverse(Input_List, Reversed),
  nth0(0, Input_List, First_Element),
  F1 is First_Element + 1,
  nth0(0, Reversed, R_First_Element),
  F2 is R_First_Element - 1,
  find_L(Input_List, [], [], F1, L, Index_L, 0),
  length(Input_List, Input_Length),
  NL is Input_Length + 1,
  find_R(Reversed, [], [], F2, R, Index_R, NL),    
  reverse(R, Reversed_R),
  Temp_Max is 0,
  reverse(Index_R, R_Index_R), !,
  outer_loop(L, Reversed_R, Index_L, R_Index_R, Temp_Max, Max_Distance).

find_L([], Temp, Index_temp, _, L, Index_L, _) :-
   reverse(Temp, L),
   reverse(Index_temp, Index_L),
   !.
find_L([H|T], Temp, Index_temp, Min, L, Index_L, Counter) :-
     New_Counter is Counter + 1,
  (   
     H < Min     
  -> !,find_L(T, [H|Temp], [New_Counter|Index_temp], H, L, Index_L, New_Counter),! 
  ;  !,find_L(T, Temp, Index_temp, Min, L, Index_L, New_Counter),!
  ).

find_R([], Temp, Index_temp, _, R, Index_R, _) :-
  reverse(Temp, R),
  reverse(Index_temp, Index_R),
  !.
find_R([H|T], Temp, Index_temp, Max, R, Index_R, Counter) :-
    New_Counter is Counter - 1,
  (
    H > Max
  -> !,find_R(T, [H|Temp], [New_Counter|Index_temp], H, R, Index_R, New_Counter),!
  ;  !,find_R(T, Temp, Index_temp, Max, R, Index_R, New_Counter),!
  ).      

read_input(File, Input_List) :-
  open(File, read, Stream),
  read_line(Stream, _),
  read_line(Stream, Input_List),
  close(Stream).
read_line(Stream, List) :-
  read_line_to_codes(Stream, Line),
  ( Line = [] -> List =[]
  ; atom_codes(A, Line),
    atomic_list_concat(As, ' ', A),
    maplist(atom_number, As, List)  
  ).  

print_list([]) :- nl.
print_list([H1|T1]) :-
  write(H1),
  write(' '),
  print_list(T1).  

outer_loop([_|_], [], [_|_], [], Dist_Temp, Dist_Temp) :- !.%, true.
outer_loop([], [_|_], [], [_|_], Dist_Temp, Dist_Temp) :- !.%, true.
outer_loop([H1|T1], [H2|T2], [IH1|IT1], [IH2|IT2], Dist_Temp, Max_Distance) :-
  (   H1 =< H2
    -> (    New_Dist is IH2 - IH1,
            New_Dist > Dist_Temp
        ->  !,outer_loop([H1|T1], T2, [IH1|IT1], IT2, New_Dist, Max_Distance),!
        ;   !,outer_loop([H1|T1], T2, [IH1|IT1], IT2, Dist_Temp, Max_Distance),!
       )
    ; !,outer_loop(T1, [H2|T2], IT1, [IH2|IT2], Dist_Temp, Max_Distance),!              
  ).