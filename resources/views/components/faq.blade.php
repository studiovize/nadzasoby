@php
    $faq = [
        [
            'question' => 'Zapomněl jsem heslo',
            'answer' => 'Z bezpečnostních důvodů heslo nesdělujeme. V sekci přihlášení klikněte na "<a href="'. route('password.request') .'" class="font-bold">Zapomenuté heslo</a>". Následně vyplníte email, který byl vámi použit při registraci a my vám v co nejbližší době pošleme na tento email potvrzení ke změně nového hesla.'
        ],
        [
            'question' => 'Kolik stojí přidání jednoho nebo více inzerátů?',
            'answer' => 'Vložení inzerátu do všech kategorií je <b>ZDARMA</b>. Pro vložení pouze potřebujete registraci. Ta je snadná a rychlá.'
        ],
        [
            'question' => 'Vložil jsem si inzerát, ale nemůžu ho najít',
            'answer' => 'Do políčka vyhledávače na hlavní stránce napište své telefonní číslo, které jste uvedli v inzerátu. Na hlavní stránce klikněte na "Vaše jméno" (musíte být přihlášení ke svému účtu) a následně zvolíte "<a href="' . route('listings.my') . '" class="font-bold">Moje inzeráty</a>" zde uvidíte, jestli byl inzerát vůbec vložen. Jelikož každý inzerát prochází systémovou kontrolou (z bezpečnostních důvodů), je možné, že vložení bude chvilku trvat, než bude inzerát zařazen mezi ostatní.'
        ],
        [
            'question' => 'Na serveru jsou inzeráty, kde je můj telefon, ale inzerát jsem si nevložil',
            'answer' => 'Napište nám na mail o který inzerát se jedná popř.zkopírujte a pošlete nám odkaz tohoto inzerátu, my jej obratem vymažeme a zjistíme, co bylo příčinnou.'
        ],
        [
            'question' => 'Jak fungují kredity?',
            'answer' => 'Kredity jsou klíčem k propojení vás s inzerující osobou a naopak. Zakoupením kreditů získáte možnost nahlédnout na jednotlivé inzeráty, o které máte zájem. Po odemčení za 1 kredit se vám zobrazí chat s inzerující osobou, telefonní číslo na inzerce a bližší informace o produktech. Při koupi 50 ks kreditů získáváte ještě zdarma 5 ks kreditů = celkem budete mít 55 ks kreditů. Při koupi 100 ks kreditů získáváte zdarma 10 ks kreditů =  celkem 110 ks kreditů.'
        ],
        [
            'question' => 'Byl jsem podveden, jak postupovat?',
            'answer' => 'Podejte trestní oznámení. Lze je podat ústně či písemně na kterémkoli oddělení policie, ale také na jakémkoliv úřadu vyšetřování a státním zastupitelství. Tyto orgány mají povinnost oznámení přijmout a bez časových ztrát věc vyšetřit. V trestném oznámení napište, co se přesně stalo (kdy, kde a kdo se trestného činu dopustil). Přiložte kopii inzerátu, doklad o zaplacení atd. Nezapomeňte uvést, že chcete být informováni o učiněných opatřeních.'
        ],
        [
            'question' => 'Nedaří se mi k inzerátu vložit fotografie',
            'answer' => 'Fotografie musí být ve formátu .png nebo .jpeg. Pokud jsou moc velké, může nahrání trvat i několik minut podle rychlosti připojení.'
        ],
        [
            'question' => 'Potřebuji kontakt z inzerátu, který už neexistuje',
            'answer' => 'Napište nám na mail alespoň část textu inzerátu, telefonní číslo, jméno inzerenta, … cokoliv, podle čeho by se dal zpětně inzerát dohledat a my vám jej pak pošleme na mail.'
        ],
    ];
@endphp

<div {{ $attributes->merge(['class' => 'grid grid-cols-1 lg:grid-cols-2 gap-8']) }}>
    @foreach($faq as $item)
        <article class="border rounded-lg border-gray-300 p-4">
            <header>
                <h3 class="text-xl font-bold">{{ $item['question'] }}</h3>
                <div class="w-6 h-0.5 bg-red-500 my-3"></div>
            </header>
            <p class="max-w-2xl">
                {!! $item['answer'] !!}
            </p>
        </article>
    @endforeach
</div>

@push('scripts')
    <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [
                    @foreach($faq as $item)
            {
                "@type": "Question",
                "name": "{{ $item['question'] }}",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "{!! addslashes(strip_tags($item['answer'])) !!}"
                        }
                    }@if(!$loop->last),@endif
        @endforeach
        ]
    }
</script>
@endpush
