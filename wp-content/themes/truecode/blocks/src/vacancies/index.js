const { withSelect } = wp.data;

export const name = 'tc/vacancies';

export const settings = {
    title: 'Вакансии',
    icon: 'admin-post',
    category: 'widgets',

    edit: withSelect((select) => {
        return {
        posts: select('core').getEntityRecords('postType', 'vacancy', {
            per_page: 3,
            _embed: true
        }),
        isLoading: select('core/data').isResolving('core', 'getEntityRecords', [
            'postType', 
            'vacancy', 
            { per_page: 3, _embed: true }
        ])
        };
    })(({ posts, isLoading }) => {
        if (isLoading) {
        return <p>Загрузка записей...</p>;
        }

        if (!posts || posts.length === 0) {
        return <p>Нет записей для отображения</p>;
        }

        return (
        <div className="recent-posts-block">
            <ul>
            {posts.map((post) => (
                <li key={post.id}>
                <a href={post.link}>
                    {post.title.rendered}
                </a>
                {post._embedded && post._embedded['wp:featuredmedia'] && (
                    <img 
                    src={post._embedded['wp:featuredmedia'][0].source_url} 
                    alt={post.title.rendered}
                    style={{ maxWidth: '100px', height: 'auto' }}
                    />
                )}
                </li>
            ))}
            </ul>
        </div>
        );
    }),

    save: () => null
};