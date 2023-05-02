import React, {useEffect, useState} from "react";
import {render} from "react-dom";
import FormEdit from "./components/FormEdit";
import Preview from "./components/Preview";
import {toCurrency} from "./helpers/numbers";

const fillable = ['title', 'type', 'content', 'category', 'category_name', 'condition', 'price', 'images', 'tax_included', 'is_negotiable', 'is_price_in_content'];

function FormEditPage() {
    const [data, setData] = useState(null);
    const [listingType, setListingType] = useState('sell');

    useEffect(() => {
        console.log('DATA', data);
    }, [data]);

    useEffect(() => {
        if (window && window.listing) {
            console.log(window.listing);
            const listing = JSON.parse(window.listing);
            setData(listing);
        }
    }, []);

    // useEffect(() => {
    //     if (data.type !== 'sell' && data.type !== 'buy') {
    //         setListingType(data.type === 'Nabídka' ? 'sell' : 'buy');
    //     }
    // }, [data.type]);

    const onChange = (key, val) => {
        if (fillable.includes(key)) {
            if (key === 'price') val = toCurrency(val);

            if (key === 'images') {
                if (!data.thumbnail) {
                    setData({...data, thumbnail: val});
                }
            } else {
                setData({...data, [key]: val});
            }

        }
    };

    return (
        <div className="flex flex-col md:flex-row gap-4">
            <section className="w-full">
                <div className={'bg-white overflow-hidden p-6 border-b-2 border-gray-200'}>
                    <FormEdit onChange={onChange} formData={data} listingType={listingType}/>
                </div>
            </section>
            {/*<aside className="w-full md:w-1/2 lg:w-1/3">*/}
            {/*    <div className={'bg-white overflow-hidden p-6 border-b-2 border-gray-200 sticky top-4'}>*/}
            {/*        <header className="mb-4">*/}
            {/*            <h2 className="text-2xl font-bold">Náhled</h2>*/}
            {/*        </header>*/}

            {/*        <Preview {...data}/>*/}
            {/*    </div>*/}
            {/*</aside>*/}
        </div>
    )
}


render(<FormEditPage/>, document.getElementById("form-create"));
