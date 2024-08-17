hopping(File, Answer) :-
    read_input(File, N, K, B, Steps, Broken),
    empty_assoc(Empty),
    make_assoc(Empty, Steps, Assoc_K, 0, K, 0, Check, N),
    make_assoc(Empty, Broken, Assoc_B, 0, B),
    empty_assoc(F0),
    initialize_F1(N, 0, F0, NewF0),
    initialize_F2(B, 0, NewF0, F1, Assoc_B),
    put_assoc(0, F1, 0, F2),
    put_assoc(1, F2, 1, F),
    (
      Check = 1,
      N \= 1
      -> outer_loop(N, K, B, F, Assoc_K, Assoc_B, 2, F_Final),
         get_assoc(N, F_Final, Temp_Answer),
         Answer is Temp_Answer + 1
      ;  outer_loop(N, K, B, F, Assoc_K, Assoc_B, 2, F_Final),
         get_assoc(N, F_Final, Answer)
    ). 

make_assoc(Temp_Assoc, _, Temp_Assoc, Size, Size, Temp_C, Check, _) :-
    (
      Temp_C \= 1
      -> Check is 0
      ; Check = Temp_C
    ).
make_assoc(Temp_Assoc, [H|T], Assoc_List, Index, Size, Temp_C, Check, N) :-
    Index < Size, 
    put_assoc(Index, Temp_Assoc, H, New_Assoc),
    (
      H \= N
      -> New_Index is Index + 1,
         make_assoc(New_Assoc, T, Assoc_List, New_Index, Size, Temp_C, Check, N)
      ;  New_Check = 1,
         New_Index is Index + 1,
         make_assoc(New_Assoc, T, Assoc_List, New_Index, Size, New_Check, Check, N)
    ).

make_assoc(Temp_Assoc, _, Temp_Assoc, Size, Size).
make_assoc(Temp_Assoc, [H|T], Assoc_List, Index, Size) :-
    Index < Size, 
    put_assoc(Index, Temp_Assoc, H, New_Assoc),
    New_Index is Index + 1,
    make_assoc(New_Assoc, T, Assoc_List, New_Index, Size), !.

initialize_F1(N, I, Temp_F, F) :-
    I > N,
    F = Temp_F.
initialize_F1(N, I, Temp_F, F) :-
    I =< N,
    put_assoc(I, Temp_F, -1, NF),
    New_I is I + 1,
    initialize_F1(N, New_I, NF, F), !.

initialize_F2(B, B, F, F, Broken_S).
initialize_F2(B, I, Temp_F, F, Broken_S) :- 
    I < B,
    get_assoc(I, Broken_S, Val),
    put_assoc(Val, Temp_F, 0, NF),
    New_I is I + 1,
    initialize_F2(B, New_I, NF, F, Broken_S), !.

outer_loop(N, K, B, F, Steps, Broken, I, F_Final) :-
    I > N,
    F_Final = F.
outer_loop(N, K, B, F, Steps, Broken, I, F_Final) :-
    I =< N,
    (
        get_assoc(I, F, Val),
        Val \= 0
        -> inner_loop(K, F, Steps, I, 0, New_Sum, 0),
           Temp is New_Sum mod 1000000009,
           put_assoc(I, F, Temp, New_F),
           New_I is I + 1,
           outer_loop(N, K, B, New_F, Steps, Broken, New_I, F_Final), !
        ;  New_I is I + 1,
           outer_loop(N, K, B, F, Steps, Broken, New_I, F_Final), !
    ).

inner_loop(K, F, Steps, I, Temp_Sum, New_Sum, J) :-
    (
        J < K
        -> (  get_assoc(J, Steps, Val),
              Temp is I - Val,
              Temp >= 0
              -> get_assoc(Temp, F, Elem),
                 NS is Temp_Sum + Elem,
                 NJ is J + 1,
                 inner_loop(K, F, Steps, I, NS, New_Sum, NJ), !
              ;  NJ is J + 1,
                 inner_loop(K, F, Steps, I, Temp_Sum, New_Sum, NJ), !
           )   
        ;  New_Sum = Temp_Sum   
    ).

read_input(File, N, K, B, Steps, Broken) :-
    open(File, read, Stream),
    read_line(Stream, [N, K, B]),
    read_line(Stream, Steps),
    (
      B \= 0
      -> read_line(Stream, Broken)
      ; Broken = []
    ).

read_line(Stream, List) :-
    read_line_to_codes(Stream, Line),
    ( Line = [] -> List = []
    ; atom_codes(A, Line),
      atomic_list_concat(As, ' ', A),
      maplist(atom_number, As, List)
    ).

% den leitourgei akoma gia otan h teleutaia grammh einai kenh
% (den yparxoun katholou spasmena skalopatia...)    